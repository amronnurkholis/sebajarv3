<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\CostumeImage;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CostumeController extends Controller
{
    /**
     * Menampilkan daftar kostum admin.
     */
    public function index(Request $request): View
    {
        $query = Costume::query()
            ->with(['sizes', 'images' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')]);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $costumes = $query
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('admin.costume.index', compact('costumes'));
    }

    /**
     * Form tambah kostum.
     */
    public function create(): View
    {
        return view('admin.costume.create');
    }

    /**
     * Validasi umum data kostum.
     */
    private function rules(?Costume $costume = null): array
    {
        $codeRule = [
            'required',
            'string',
            'max:50',
        ];

        if ($costume) {
            $codeRule[] = 'unique:costumes,code,' . $costume->id;
        } else {
            $codeRule[] = 'unique:costumes,code';
        }

        return [
            'code' => $codeRule,
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],

            // Format baru: images[]
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            // Format lama tetap diterima agar upload lama tidak rusak.
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'baju' => ['nullable', 'array'],
            'baju.*' => ['nullable', 'integer', 'min:0'],

            'celana' => ['nullable', 'array'],
            'celana.*' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Mengambil seluruh file gambar dari request.
     * Mendukung images[] dan field image lama.
     */
    private function uploadedImages(Request $request): array
    {
        $files = $request->file('images', []);

        if (!is_array($files)) {
            $files = [$files];
        }

        // Kompatibilitas dengan form lama.
        if (empty($files) && $request->hasFile('image')) {
            $files = [$request->file('image')];
        }

        return array_values(array_filter($files));
    }

    /**
     * Menyimpan gambar ke gallery costume_images.
     */
    private function storeGalleryImages(Costume $costume, array $files): void
    {
        if (empty($files)) {
            return;
        }

        $nextSort = (int) $costume->images()->max('sort_order') + 1;

        foreach ($files as $file) {
            $path = $file->store('costumes', 'public');

            $costume->images()->create([
                'image_path' => $path,
                'sort_order' => $nextSort++,
            ]);
        }
    }

    /**
     * Menyimpan kostum baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $files = $this->uploadedImages($request);

        DB::transaction(function () use ($validated, $files) {
            $costume = Costume::create([
                'code' => strtoupper(trim($validated['code'])),
                'name' => trim($validated['name']),
                'image' => null,
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            // Gambar pertama tetap disimpan di costumes.image
            // untuk kompatibilitas dengan data/view lama.
            if (!empty($files)) {
                $firstPath = $files[0]->store('costumes', 'public');
                $costume->update(['image' => $firstPath]);

                $costume->images()->create([
                    'image_path' => $firstPath,
                    'sort_order' => 0,
                ]);

                foreach (array_slice($files, 1) as $file) {
                    $costume->images()->create([
                        'image_path' => $file->store('costumes', 'public'),
                        'sort_order' => $costume->images()->max('sort_order') + 1,
                    ]);
                }
            }

            foreach ($validated['baju'] ?? [] as $size => $quantity) {
                $quantity = (int) ($quantity ?? 0);

                if ($quantity <= 0) {
                    continue;
                }

                $costume->sizes()->create([
                    'category' => 'baju',
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }

            foreach ($validated['celana'] ?? [] as $size => $quantity) {
                $quantity = (int) ($quantity ?? 0);

                if ($quantity <= 0) {
                    continue;
                }

                $costume->sizes()->create([
                    'category' => 'celana',
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }
        });

        return redirect()
            ->route('admin.costumes.index')
            ->with('success', 'Kostum berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kostum admin.
     */
    public function show(Costume $costume): View
    {
        $costume->load([
            'sizes',
            'images' => fn ($q) => $q->orderBy('sort_order')->orderBy('id'),
        ]);

        return view('admin.costume.show', compact('costume'));
    }

    /**
     * Form edit kostum.
     */
    public function edit(Costume $costume): View
    {
        $costume->load([
            'sizes',
            'images' => fn ($q) => $q->orderBy('sort_order')->orderBy('id'),
        ]);

        return view('admin.costume.edit', compact('costume'));
    }

    /**
     * Memperbarui kostum.
     *
     * Upload gambar baru bersifat ADDITIVE:
     * gambar lama tidak dihapus hanya karena admin menambah gambar baru.
     */
    public function update(Request $request, Costume $costume)
    {
        $validated = $request->validate($this->rules($costume));

        $files = $this->uploadedImages($request);

        try {
            DB::transaction(function () use ($validated, $files, $costume) {
                $data = [
                    'code' => strtoupper(trim($validated['code'])),
                    'name' => trim($validated['name']),
                    'description' => $validated['description'] ?? null,
                    'status' => $validated['status'],
                ];

                $costume->update($data);

                // Gambar baru ditambahkan ke gallery, bukan menggantikan gambar lama.
                if (!empty($files)) {
                    $this->storeGalleryImages($costume, $files);

                    // Jika costume.image belum ada, jadikan gambar baru pertama
                    // sebagai gambar legacy/utama.
                    if (!$costume->image) {
                        $first = $costume->images()
                            ->orderBy('sort_order')
                            ->orderBy('id')
                            ->first();

                        if ($first) {
                            $costume->update([
                                'image' => $first->image_path,
                            ]);
                        }
                    }
                }

                foreach ($validated['baju'] ?? [] as $size => $quantity) {
                    $costume->sizes()->updateOrCreate(
                        ['category' => 'baju', 'size' => $size],
                        ['quantity' => (int) ($quantity ?? 0)]
                    );
                }

                foreach ($validated['celana'] ?? [] as $size => $quantity) {
                    $costume->sizes()->updateOrCreate(
                        ['category' => 'celana', 'size' => $size],
                        ['quantity' => (int) ($quantity ?? 0)]
                    );
                }
            });
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Perubahan kostum gagal disimpan. Silakan coba lagi.');
        }

        return redirect()
            ->route('admin.costumes.edit', $costume)
            ->with('success', 'Kostum berhasil diperbarui.');
    }

    /**
     * Menghapus satu gambar gallery milik kostum yang sedang diedit.
     * Gambar legacy/static yang tidak memiliki record CostumeImage tidak
     * pernah diproses oleh endpoint ini.
     */
    public function destroyImage(Costume $costume, CostumeImage $image)
    {
        abort_unless($image->costume_id === $costume->id, 404);

        $imagePath = ltrim((string) $image->image_path, '/');

        DB::transaction(function () use ($costume, $image, $imagePath) {
            // Apabila gambar yang dihapus juga adalah cover legacy, gunakan
            // gambar gallery berikutnya sebagai cover agar referensi lama
            // tidak menunjuk file yang sudah tidak ada.
            if ($costume->image === $imagePath) {
                $replacement = $costume->images()
                    ->where('id', '!=', $image->id)
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->value('image_path');

                $costume->update(['image' => $replacement]);
            }

            $image->delete();
        });

        // Hanya hapus file yang dibuat uploader gallery ini. Path static,
        // URL eksternal, maupun path di luar folder costumes tidak disentuh.
        if (
            str_starts_with($imagePath, 'costumes/')
            && !str_contains($imagePath, '..')
            && Storage::disk('public')->exists($imagePath)
        ) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.costumes.edit', $costume)
            ->with('success', 'Gambar kostum berhasil dihapus.');
    }

    /**
     * Menghapus kostum.
     *
     * Kostum yang sudah mempunyai riwayat rental tidak boleh
     * dihapus permanen agar histori transaksi tetap aman.
     */
    public function destroy(Costume $costume)
    {
        $hasRentalHistory = Rental::query()
            ->where('costume_code', $costume->code)
            ->exists();

        if ($hasRentalHistory) {
            return redirect()
                ->route('admin.costumes.index')
                ->with(
                    'error',
                    'Kostum tidak dapat dihapus karena sudah memiliki riwayat rental. Ubah status menjadi Nonaktif.'
                );
        }

        DB::transaction(function () use ($costume) {
            $costume->load('images');

            // Hapus semua file gallery yang tersimpan di disk public.
            foreach ($costume->images as $image) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            // Hapus gambar legacy jika belum terwakili oleh gallery.
            if ($costume->image) {
                $galleryPaths = $costume->images
                    ->pluck('image_path')
                    ->filter()
                    ->values()
                    ->all();

                if (!in_array($costume->image, $galleryPaths, true)) {
                    Storage::disk('public')->delete($costume->image);
                }
            }

            // costume_images akan ikut terhapus melalui cascade jika
            // foreign key migration menggunakan cascadeOnDelete().
            $costume->delete();
        });

        return redirect()
            ->route('admin.costumes.index')
            ->with('success', 'Kostum berhasil dihapus.');
    }
}
