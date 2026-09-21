<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Rental;
use Illuminate\View\View;
use App\Services\RentalScheduleService;

class AdminDashboardController extends Controller
{
    public function __invoke(RentalScheduleService $rentalSchedule): View
    {
        $totalCostumes = Costume::where('status', 'active')->count();

        $totalSets = Costume::where('status', 'active')
            ->with('sizes')
            ->get()
            ->sum(function ($costume) {
                return min(
                    $costume->sizes
                        ->where('category', 'baju')
                        ->sum('quantity'),

                    $costume->sizes
                        ->where('category', 'celana')
                        ->sum('quantity')
                );
            });

        $pendingRentals = Rental::where('status', 'pending')->count();

        $activeRentals = Rental::where('status', 'approved')->count();

        $completedRentals = Rental::where('status', 'completed')->count();

        $rejectedRentals = Rental::where('status', 'rejected')->count();

        $recentRentals = Rental::latest()
            ->take(5)
            ->get();

        $lowStockCostumes = Costume::where('status', 'active')
            ->with('sizes')
            ->get()
            ->filter(function ($costume) {
                $totalBaju = $costume->sizes
                    ->where('category', 'baju')
                    ->sum('quantity');

                $totalCelana = $costume->sizes
                    ->where('category', 'celana')
                    ->sum('quantity');

                return min($totalBaju, $totalCelana) <= 5;
            })
            ->take(5);

        $rentalStatus = $rentalSchedule->status();

        return view('admin.dashboard', compact(
            'totalCostumes',
            'totalSets',
            'pendingRentals',
            'activeRentals',
            'completedRentals',
            'rejectedRentals',
            'recentRentals',
            'lowStockCostumes',
            'rentalStatus'
        ));
    }
}
