<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\RentalScheduleService;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('sizes')
            ->latest()
            ->paginate(15);

        $pendingCount = Rental::where('status', 'pending')->count();
        $approvedCount = Rental::where('status', 'approved')->count();
        $completedCount = Rental::where('status', 'completed')->count();
        $rejectedCount = Rental::where('status', 'rejected')->count();

        // Kompatibilitas dengan view admin lama.
        $ongoingCount = Rental::where('status', 'ongoing')->count();

        return view('admin.rentals.index', compact(
            'rentals',
            'pendingCount',
            'approvedCount',
            'ongoingCount',
            'completedCount',
            'rejectedCount'
        ));
    }

    public function show(Rental $rental)
    {
        $rental->load('sizes');

        $costume = Costume::where(
            'code',
            strtoupper($rental->costume_code)
        )->first();

        return view('admin.rentals.show', compact(
            'rental',
            'costume'
        ));
    }

    public function create(Request $request, RentalScheduleService $rentalSchedule)
    {
        $selectedCode = strtoupper(
            str_replace(
                ' ',
                '-',
                $request->query('kostum', old('costume_code', ''))
            )
        );

        $costume = Costume::with('sizes')
            ->where('code', $selectedCode)
            ->where('status', 'active')
            ->first();

        if (! $costume) {
            $costume = Costume::with('sizes')
                ->where('status', 'active')
                ->orderBy('code')
                ->first();
        }

        if (! $costume) {
            abort(404, 'Belum ada kostum aktif.');
        }

        $rentalDate = $request->query(
            'rental_date',
            old('rental_date')
        );

        $rentalStatus = $rentalSchedule->status();

        if (! $rentalStatus['is_open']) {
            return redirect()->route('koleksi')->with('error', $rentalStatus['closed_message']);
        }

        return view('penyewaan', compact(
            'costume',
            'rentalDate',
            'rentalStatus'
        ));
    }

    public function availability(Request $request, RentalScheduleService $rentalSchedule): JsonResponse
    {
        if (! $rentalSchedule->status()['is_open']) {
            return response()->json(['available' => false, 'message' => $rentalSchedule->status()['closed_message']], 423);
        }
        $validated = $request->validate([
            'costume_code' => ['required', 'string', 'max:50'],
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'rental_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $costume = Costume::with('sizes')
            ->where('code', strtoupper($validated['costume_code']))
            ->where('status', 'active')
            ->first();

        if (! $costume) {
            return response()->json([
                'available' => false,
                'available_stock' => 0,
                'message' => 'Kostum tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        $availability = app(
            \App\Services\RentalAvailabilityService::class
        );

        $availableStock = $availability->getAvailableStock(
            $costume,
            $validated['rental_date']
        );

        $requestedQuantity = (int) $validated['quantity'];

        return response()->json([
            'available' => $availableStock >= $requestedQuantity,
            'available_stock' => $availableStock,
            'available_sizes' => $availability->getAvailableSizeStock(
                $costume,
                $validated['rental_date']
            ),
            'requested_quantity' => $requestedQuantity,
            'message' => $availableStock >= $requestedQuantity
                ? 'Kostum tersedia.'
                : 'Stok kostum tidak mencukupi pada saat ini.',
        ]);
    }

    public function store(Request $request, RentalScheduleService $rentalSchedule)
    {
        $rentalStatus = $rentalSchedule->status();
        if (! $rentalStatus['is_open']) {
            throw ValidationException::withMessages(['rental' => $rentalStatus['closed_message']]);
        }
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'team_name' => ['required', 'string', 'max:100'],
            'phone' => [
                'required',
                'string',
                'max:25',
                'regex:/^[0-9+\-\s()]+$/',
            ],
            'costume_code' => ['required', 'string', 'max:50'],
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'rental_date' => ['required', 'date', 'after_or_equal:today'],

            'baju' => ['required', 'array'],
            'baju.*' => ['nullable', 'integer', 'min:0'],

            'celana' => ['required', 'array'],
            'celana.*' => ['nullable', 'integer', 'min:0'],
        ], [
            'customer_name.required' => 'Nama penyewa wajib diisi.',
            'team_name.required' => 'Nama tim wajib diisi.',
            'phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'phone.regex' => 'Format nomor HP / WhatsApp tidak valid.',
            'costume_code.required' => 'Kostum wajib dipilih.',
            'quantity.required' => 'Jumlah set wajib diisi.',
            'quantity.min' => 'Jumlah set minimal 1.',
            'quantity.max' => 'Jumlah set maksimal 20.',
            'rental_date.required' => 'Tanggal sewa wajib dipilih.',
            'baju.required' => 'Ukuran baju wajib dipilih.',
            'celana.required' => 'Ukuran celana wajib dipilih.',
        ]);

        $shirtSizes = collect($validated['baju'])
            ->mapWithKeys(fn ($quantity, $size) => [
                (string) $size => (int) ($quantity ?? 0),
            ])
            ->filter(fn ($quantity) => $quantity > 0);

        $pantsSizes = collect($validated['celana'])
            ->mapWithKeys(fn ($quantity, $size) => [
                (string) $size => (int) ($quantity ?? 0),
            ])
            ->filter(fn ($quantity) => $quantity > 0);

        $requestedQuantity = (int) $validated['quantity'];

        if ($shirtSizes->sum() !== $requestedQuantity) {
            throw ValidationException::withMessages([
                'baju' =>
                    "Total ukuran baju harus {$requestedQuantity} set. " .
                    "Saat ini {$shirtSizes->sum()} set.",
            ]);
        }

        if ($pantsSizes->sum() !== $requestedQuantity) {
            throw ValidationException::withMessages([
                'celana' =>
                    "Total ukuran celana harus {$requestedQuantity} set. " .
                    "Saat ini {$pantsSizes->sum()} set.",
            ]);
        }

        $costume = Costume::with('sizes')
            ->where('code', strtoupper($validated['costume_code']))
            ->where('status', 'active')
            ->first();

        if (! $costume) {
            throw ValidationException::withMessages([
                'costume_code' => 'Kostum tidak ditemukan atau tidak aktif.',
            ]);
        }

        $costumeSizes = $costume->sizes->keyBy(
            fn ($size) => $size->category . '|' . $size->size
        );

        foreach ($shirtSizes as $size => $quantity) {
            $key = 'baju|' . $size;

            if (! $costumeSizes->has($key)) {
                throw ValidationException::withMessages([
                    'baju' => "Ukuran baju {$size} tidak tersedia.",
                ]);
            }

            if ($quantity > (int) $costumeSizes[$key]->quantity) {
                throw ValidationException::withMessages([
                    'baju' =>
                        "Stok baju ukuran {$size} hanya " .
                        "{$costumeSizes[$key]->quantity} pcs.",
                ]);
            }
        }

        foreach ($pantsSizes as $size => $quantity) {
            $key = 'celana|' . $size;

            if (! $costumeSizes->has($key)) {
                throw ValidationException::withMessages([
                    'celana' => "Ukuran celana {$size} tidak tersedia.",
                ]);
            }

            if ($quantity > (int) $costumeSizes[$key]->quantity) {
                throw ValidationException::withMessages([
                    'celana' =>
                        "Stok celana ukuran {$size} hanya " .
                        "{$costumeSizes[$key]->quantity} pcs.",
                ]);
            }
        }

        $availability = app(
            \App\Services\RentalAvailabilityService::class
        );

        $availableStock = $availability->getAvailableStock(
            $costume,
            $validated['rental_date']
        );

        if ($availableStock < $requestedQuantity) {
            throw ValidationException::withMessages([
                'quantity' =>
                    "Stok kostum yang tersedia hanya {$availableStock} set.",
            ]);
        }

        $requestedSizes = [
            'baju' => $shirtSizes->toArray(),
            'celana' => $pantsSizes->toArray(),
        ];

        if (! $availability->hasAvailableSizes(
            $costume,
            $requestedSizes,
            $validated['rental_date']
        )) {
            throw ValidationException::withMessages([
                'quantity' =>
                    'Salah satu ukuran yang dipilih sudah tidak mencukupi. ' .
                    'Silakan periksa kembali ukuran yang tersedia.',
            ]);
        }

        DB::transaction(function () use (
            $validated,
            $costume,
            $shirtSizes,
            $pantsSizes
        ) {
            /*
             * Database lama masih memiliki rental_start/rental_end.
             * Karena sistem sekarang hanya memakai satu tanggal,
             * keduanya diisi dengan tanggal yang sama.
             */
            $rental = Rental::create([
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'team_name' => $validated['team_name'],
                'phone' => $validated['phone'],
                'costume_code' => strtoupper($costume->code),
                'quantity' => (int) $validated['quantity'],
                'rental_start' => $validated['rental_date'],
                'rental_end' => $validated['rental_date'],
                'status' => 'pending',
            ]);

            foreach ($shirtSizes as $size => $quantity) {
                $rental->sizes()->create([
                    'category' => 'baju',
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }

            foreach ($pantsSizes as $size => $quantity) {
                $rental->sizes()->create([
                    'category' => 'celana',
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }
        });

        return redirect()
            ->route('pesanan')
            ->with(
                'success',
                'Pengajuan penyewaan berhasil dikirim. Tim Sebajar.id akan menghubungi kamu untuk konfirmasi.'
            );
    }

    public function approve(Rental $rental)
    {
        if ($rental->status !== 'pending') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Pengajuan ini tidak dapat disetujui karena statusnya sudah ' .
                    $rental->status . '.'
                );
        }

        $costume = Costume::with('sizes')
            ->where('code', strtoupper($rental->costume_code))
            ->where('status', 'active')
            ->first();

        if (! $costume) {
            return redirect()
                ->back()
                ->with('error', 'Kostum tidak ditemukan atau tidak aktif.');
        }

        $rental->load('sizes');

        if ($rental->sizes->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'Pengajuan ini belum memiliki data ukuran.');
        }

        /*
         * Pending sudah mengunci stok. Kita hanya mengubah statusnya
         * menjadi approved; stok fisik tidak dikurangi.
         */
        $rental->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.rentals.show', $rental)
            ->with('success', 'Pengajuan penyewaan berhasil disetujui.');
    }

    public function reject(Request $request, Rental $rental)
    {
        if ($rental->status !== 'pending') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Pengajuan ini tidak dapat ditolak karena statusnya sudah ' .
                    $rental->status . '.'
                );
        }

        $rental->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.rentals.show', $rental)
            ->with('success', 'Pengajuan penyewaan telah ditolak.');
    }

    public function complete(Rental $rental)
    {
        if ($rental->status !== 'approved') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Pengajuan ini tidak dapat diselesaikan karena statusnya ' .
                    $rental->status . '.'
                );
        }

        $rental->update([
            'status' => 'completed',
        ]);

        return redirect()
            ->route('admin.rentals.show', $rental)
            ->with(
                'success',
                'Penyewaan telah selesai dan stok kembali tersedia.'
            );
    }
}
