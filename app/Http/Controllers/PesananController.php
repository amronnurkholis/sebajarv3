<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(): View
    {
        $rentals = Rental::with(['sizes', 'costume.images'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pesanan.index', compact('rentals'));
    }
}
