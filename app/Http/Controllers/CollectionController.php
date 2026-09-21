<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Services\RentalAvailabilityService;
use App\Services\RentalScheduleService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(
        Request $request,
        RentalAvailabilityService $availability,
        RentalScheduleService $rentalSchedule
    ): View {
        $costumes = Costume::with(['sizes', 'images'])
            ->where('status', 'active')
            ->orderBy('code')
            ->get();

        $rentalDate = $request->query('rental_date');

        $stock = [];

        foreach ($costumes as $costume) {
            $total = $availability->getTotalStock($costume);

            if ($rentalDate) {
                $reserved = $availability->getReservedStock(
                    $costume->code,
                    $rentalDate
                );
                $available = max(0, $total - $reserved);
                $sizes = $availability->getAvailableSizeStock(
                    $costume,
                    $rentalDate
                );
            } else {
                // Sebelum tanggal dipilih, tampilkan stok fisik sebagai
                // informasi awal. Status sewa baru dihitung setelah user
                // menekan tombol OK pada tanggal.
                $reserved = 0;
                $available = $total;
                $sizes = $availability->getSizeStock($costume);
            }

            $stock[$costume->code] = [
                'total' => $total,
                'reserved' => $reserved,
                'available' => $available,
                'sizes' => $sizes,
            ];
        }

        $rentalStatus = $rentalSchedule->status();

        return view('koleksi', compact(
            'costumes',
            'rentalDate',
            'stock',
            'rentalStatus'
        ));
    }

    public function show(string $code, RentalScheduleService $rentalSchedule): View
    {
        $costume = Costume::with([
            'images' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
            'sizes',
        ])
            ->where(
                'code',
                strtoupper(str_replace(' ', '-', $code))
            )
            ->where('status', 'active')
            ->firstOrFail();

        $rentalStatus = $rentalSchedule->status();

        return view('detail-kostum', compact('costume', 'rentalStatus'));
    }
}
