<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\Setting;
use App\Services\RentalScheduleService;

class SettingsController extends Controller
{
    public function edit(RentalScheduleService $rentalSchedule): View
    {
        return view('admin.settings.index', [
            'user' => auth()->user(),
            'rentalSettings' => $rentalSchedule->settings(),
            'rentalStatus' => $rentalSchedule->status(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($user->id),
            ],
            'current_password' => ['nullable', 'current_password'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'rental_automatic' => ['nullable', 'boolean'],
            'rental_manual_open' => ['nullable', 'boolean'],
            'rental_open_time' => ['nullable', 'date_format:H:i'],
            'rental_close_time' => ['nullable', 'date_format:H:i'],
            'rental_closed_message' => ['nullable', 'string', 'max:200'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama tersebut sudah digunakan.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->name = $validated['name'];

        if (filled($validated['password'] ?? null)) {
            if (blank($validated['current_password'] ?? null)) {
                return back()->withInput()->withErrors([
                    'current_password' => 'Masukkan password saat ini untuk mengganti password.',
                ]);
            }

            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($request->has('rental_open_time')) {
            foreach ([
                'rental_automatic' => $request->boolean('rental_automatic') ? '1' : '0',
                'rental_manual_open' => $request->boolean('rental_manual_open') ? '1' : '0',
                'rental_open_time' => $validated['rental_open_time'],
                'rental_close_time' => $validated['rental_close_time'],
                'rental_closed_message' => $validated['rental_closed_message'],
            ] as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return back()->with('success', 'Pengaturan akun dan jadwal penyewaan berhasil diperbarui.');
    }
}
