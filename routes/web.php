<?php

use Illuminate\Support\Facades\Route;
use App\Models\Costume;
use App\Services\RentalScheduleService;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;

Route::get('/login', [
    AuthController::class,
    'loginPage'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
]);

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [
    AuthController::class,
    'register'
])->name('register.store');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');

Route::get('/', function (RentalScheduleService $rentalSchedule) {
    $costumes = Costume::query()
        ->with('images')
        ->where('status', 'active')
        ->orderBy('code')
        ->take(6)
        ->get();

    $rentalStatus = $rentalSchedule->status();
    return view('home', compact('costumes', 'rentalStatus'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
});

Route::get('/koleksi', [
    CollectionController::class,
    'index'
])->name('koleksi');

Route::get('/koleksi/{code}', [
    CollectionController::class,
    'show'
])->name('koleksi.detail');

Route::get('/penyewaan', [
    RentalController::class,
    'create'
])->middleware('auth')->name('penyewaan');

Route::post('/penyewaan', [
    RentalController::class,
    'store'
])->middleware('auth')->name('penyewaan.store');

Route::get('/penyewaan/availability', [
    RentalController::class,
    'availability'
])->name('penyewaan.availability');

Route::get('/pesanan', [
    PesananController::class,
    'index'
])->middleware('auth')->name('pesanan');

Route::middleware([
    'auth',
    'admin'
])->group(function () {
    Route::get('/admin', AdminDashboardController::class)
        ->name('admin.dashboard');

    Route::resource(
        '/admin/costumes',
        CostumeController::class
    )->names('admin.costumes');

    Route::delete('/admin/costumes/{costume}/images/{image}', [
        CostumeController::class,
        'destroyImage',
    ])->name('admin.costumes.images.destroy');

    Route::get('/admin/rentals', [
        RentalController::class,
        'index'
    ])->name('admin.rentals.index');

    Route::get('/admin/rentals/{rental}', [
        RentalController::class,
        'show'
    ])->name('admin.rentals.show');

    Route::post('/admin/rentals/{rental}/approve', [
        RentalController::class,
        'approve'
    ])->name('admin.rentals.approve');

    Route::post('/admin/rentals/{rental}/reject', [
        RentalController::class,
        'reject'
    ])->name('admin.rentals.reject');

    Route::post('/admin/rentals/{rental}/complete', [
        RentalController::class,
        'complete'
    ])->name('admin.rentals.complete');

    Route::resource('/admin/users', UserController::class)
        ->except(['show'])
        ->names('admin.users');

    Route::get('/admin/settings', [
        SettingsController::class,
        'edit'
    ])->name('admin.settings.edit');

    Route::put('/admin/settings', [
        SettingsController::class,
        'update'
    ])->name('admin.settings.update');
});
