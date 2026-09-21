@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-6"><a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-[#7B1E2B]">← Kembali ke Pengguna</a></div>
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5 rounded-2xl border border-[#E7E0D6] bg-white p-5 sm:p-7">
        @csrf
        <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Nama pengguna</label><input name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm outline-none focus:border-[#7B1E2B]">@error('name')<p class="mt-1 text-xs text-[#9A303A]">{{ $message }}</p>@enderror</div>
        <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Role</label><select name="role" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm outline-none focus:border-[#7B1E2B]"><option value="customer" @selected(old('role') === 'customer')>Customer</option><option value="admin" @selected(old('role') === 'admin')>Admin</option></select></div>
        <div class="grid gap-5 sm:grid-cols-2"><div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Password</label><input type="password" name="password" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm">@error('password')<p class="mt-1 text-xs text-[#9A303A]">{{ $message }}</p>@enderror</div><div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Konfirmasi password</label><input type="password" name="password_confirmation" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div></div>
        <button class="w-full rounded-xl bg-[#7B1E2B] px-4 py-3 text-sm font-semibold text-white hover:bg-[#681924]">Simpan Pengguna</button>
    </form>
</div>
@endsection
