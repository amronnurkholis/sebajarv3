<?php

namespace App\Services;

use App\Models\Costume;
use App\Models\Rental;
use Carbon\Carbon;

class RentalAvailabilityService
{
    /**
     * Status rental yang mengunci stok.
     *
     * pending  = menunggu persetujuan admin
     * approved = sedang disewa
     */
    private const LOCKING_STATUSES = [
        'pending',
        'approved',
    ];

    public function getTotalStock(Costume $costume): int
    {
        $shirtTotal = (int) $costume->sizes()
            ->where('category', 'baju')
            ->sum('quantity');

        $pantsTotal = (int) $costume->sizes()
            ->where('category', 'celana')
            ->sum('quantity');

        return min($shirtTotal, $pantsTotal);
    }

    /**
     * Tanggal diterima sebagai parameter kompatibilitas.
     * Sistem tidak memakai tanggal sebagai periode.
     */
    public function getReservedStock(
        string $costumeCode,
        string|Carbon|null $date = null,
        string|Carbon|null $end = null
    ): int {
        $query = Rental::query()
            ->where('costume_code', strtoupper($costumeCode))
            ->whereIn('status', self::LOCKING_STATUSES);

        // Jika tanggal dipilih, hanya rental yang benar-benar
        // beririsan dengan tanggal tersebut yang mengunci stok.
        if ($date !== null) {
            $start = Carbon::parse($date)->startOfDay();
            $finish = $end !== null ? Carbon::parse($end)->startOfDay() : $start;

            if ($finish->lt($start)) {
                [$start, $finish] = [$finish, $start];
            }

            $query->whereDate('rental_start', '<=', $finish->toDateString())
                ->whereDate('rental_end', '>=', $start->toDateString());
        }

        return (int) $query->sum('quantity');
    }

    public function getAvailableStock(
        Costume $costume,
        string|Carbon|null $date = null,
        string|Carbon|null $end = null
    ): int {
        return max(
            0,
            $this->getTotalStock($costume)
                - $this->getReservedStock($costume->code, $date, $end)
        );
    }

    public function hasAvailableStock(
        Costume $costume,
        int $quantity,
        string|Carbon|null $date = null,
        string|Carbon|null $end = null
    ): bool {
        return $quantity > 0
            && $quantity <= $this->getAvailableStock($costume, $date, $end);
    }

    public function getSizeStock(Costume $costume): array
    {
        return [
            'baju' => $costume->sizes()
                ->where('category', 'baju')
                ->where('quantity', '>', 0)
                ->pluck('quantity', 'size')
                ->map(fn ($q) => (int) $q)
                ->toArray(),

            'celana' => $costume->sizes()
                ->where('category', 'celana')
                ->where('quantity', '>', 0)
                ->pluck('quantity', 'size')
                ->map(fn ($q) => (int) $q)
                ->toArray(),
        ];
    }

    public function getReservedSizeStock(
        Costume $costume,
        string|Carbon|null $date = null,
        string|Carbon|null $end = null
    ): array {
        $reserved = [
            'baju' => [],
            'celana' => [],
        ];

        $query = Rental::query()
            ->where('costume_code', strtoupper($costume->code))
            ->whereIn('status', self::LOCKING_STATUSES)
            ->with('sizes');

        if ($date !== null) {
            $start = Carbon::parse($date)->startOfDay();
            $finish = $end !== null ? Carbon::parse($end)->startOfDay() : $start;

            if ($finish->lt($start)) {
                [$start, $finish] = [$finish, $start];
            }

            $query->whereDate('rental_start', '<=', $finish->toDateString())
                ->whereDate('rental_end', '>=', $start->toDateString());
        }

        $rentals = $query->get();

        foreach ($rentals as $rental) {
            foreach ($rental->sizes as $rentalSize) {
                $category = strtolower((string) $rentalSize->category);

                if (! isset($reserved[$category])) {
                    continue;
                }

                $size = (string) $rentalSize->size;

                $reserved[$category][$size] =
                    ($reserved[$category][$size] ?? 0)
                    + (int) $rentalSize->quantity;
            }
        }

        return $reserved;
    }

    public function getAvailableSizeStock(
        Costume $costume,
        string|Carbon|null $date = null,
        string|Carbon|null $end = null
    ): array {
        $totalSizes = $this->getSizeStock($costume);
        $reservedSizes = $this->getReservedSizeStock($costume, $date, $end);

        $available = [
            'baju' => [],
            'celana' => [],
        ];

        foreach ($totalSizes as $category => $sizes) {
            foreach ($sizes as $size => $quantity) {
                $available[$category][$size] = max(
                    0,
                    (int) $quantity
                    - (int) ($reservedSizes[$category][$size] ?? 0)
                );
            }
        }

        return $available;
    }

    public function hasAvailableSizes(
        Costume $costume,
        array $requestedSizes,
        string|Carbon|null $date = null,
        string|Carbon|null $end = null
    ): bool {
        $available = $this->getAvailableSizeStock(
            $costume,
            $date,
            $end
        );

        foreach (['baju', 'celana'] as $category) {
            foreach ($requestedSizes[$category] ?? [] as $size => $quantity) {
                $quantity = (int) $quantity;

                if ($quantity <= 0) {
                    continue;
                }

                if ($quantity > (int) ($available[$category][$size] ?? 0)) {
                    return false;
                }
            }
        }

        return true;
    }
}
