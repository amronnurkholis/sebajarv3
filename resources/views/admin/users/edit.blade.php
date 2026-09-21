@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-6"><a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-[#7B1E2B]">← Kembali ke Pengguna</a></div>
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5 rounded-2xl border border-[#E7E0D6] bg-white p-5 sm:p-7">
        @csrf @method('PUT')
        <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Nama pengguna</label><input name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm outline-none focus:border-[#7B1E2B]">@error('name')<p class="mt-1 text-xs text-[#9A303A]">{{ $message }}</p>@enderror</div>
        <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Role</label><select name="role" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"><option value="customer" @selected(old('role', $user->role) === 'customer')>Customer</option><option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option></select>@error('role')<p class="mt-1 text-xs text-[#9A303A]">{{ $message }}</p>@enderror</div>
        <div class="rounded-xl bg-[#FBF9F5] p-4"><p class="text-xs text-[#8C847B]">Kosongkan password jika tidak ingin mengubahnya.</p><div class="mt-4 grid gap-5 sm:grid-cols-2"><div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Password baru</label><input type="password" name="password" class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div><div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Konfirmasi</label><input type="password" name="password_confirmation" class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div></div>@error('password')<p class="mt-1 text-xs text-[#9A303A]">{{ $message }}</p>@enderror</div>
        <button class="w-full rounded-xl bg-[#7B1E2B] px-4 py-3 text-sm font-semibold text-white hover:bg-[#681924]">Simpan Perubahan</button>
    </form>
</div>
@endsection
