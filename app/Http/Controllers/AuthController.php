<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('name', $request->name)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user);

            if ($user->role == 'admin') {
                return redirect('/admin')
                    ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->with(
            'error',
            'Nama atau password salah'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:6|confirmed',
        ], [

            'name.required' =>
                'Nama wajib diisi.',

            'name.unique' =>
                'Nama tersebut sudah digunakan.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 6 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',

        ]);


        $user = User::create([

            'name' => $request->name,

            'password' => Hash::make(
                $request->password
            ),

            'role' => 'customer',

        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Akun berhasil dibuat. Silakan login untuk melanjutkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}