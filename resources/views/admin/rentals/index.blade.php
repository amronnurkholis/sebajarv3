@extends('layouts.admin')

@section('title', 'Pengajuan Sewa')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[#2C2926]">
                Pengajuan Sewa
            </h1>

            <p class="mt-1 text-sm text-[#8C847B]">
                Kelola pengajuan penyewaan kostum Sebajar.
            </p>
        </div>

    </div>


    {{-- Flash Message --}}
    @if (session('success'))

        <div class="rounded-xl border border-[#CFE3D1] bg-[#EEF8EF] px-5 py-4 text-sm text-[#2E7D32]">
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div class="rounded-xl border border-[#F0CACA] bg-[#FDF0F0] px-5 py-4 text-sm text-[#B3261E]">
            {{ session('error') }}
        </div>

    @endif


    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

            <p class="text-xs font-medium uppercase tracking-wide text-[#8C847B]">
                Menunggu
            </p>

            <p class="mt-2 text-3xl font-semibold text-[#7B1E2B]">
                {{ $pendingCount }}
            </p>

            <p class="mt-1 text-xs text-[#9B9187]">
                Perlu diperiksa
            </p>

        </div>


        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

            <p class="text-xs font-medium uppercase tracking-wide text-[#8C847B]">
                Total
            </p>

            <p class="mt-2 text-3xl font-semibold text-[#2C2926]">
                {{ $rentals->total() }}
            </p>

            <p class="mt-1 text-xs text-[#9B9187]">
                Semua pengajuan
            </p>

        </div>


        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

            <p class="text-xs font-medium uppercase tracking-wide text-[#8C847B]">
                Berjalan
            </p>

            <p class="mt-2 text-3xl font-semibold text-[#1565C0]">
                {{ \App\Models\Rental::where('status', 'ongoing')->count() }}
            </p>

            <p class="mt-1 text-xs text-[#9B9187]">
                Sedang disewa
            </p>

        </div>


        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

            <p class="text-xs font-medium uppercase tracking-wide text-[#8C847B]">
                Selesai
            </p>

            <p class="mt-2 text-3xl font-semibold text-[#616161]">
                {{ \App\Models\Rental::where('status', 'completed')->count() }}
            </p>

            <p class="mt-1 text-xs text-[#9B9187]">
                Rental selesai
            </p>

        </div>

    </div>


    {{-- Filter --}}
    <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('admin.rentals.index') }}"
            class="grid gap-4 md:grid-cols-[1fr_200px_auto]"
        >

            <div>

                <label
                    for="search"
                    class="mb-2 block text-xs font-medium text-[#5F5953]"
                >
                    Cari Pengajuan
                </label>

                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama, tim, WhatsApp, atau kode kostum..."
                    class="w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 text-sm text-[#2C2926] outline-none transition focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                >

            </div>


            <div>

                <label
                    for="status"
                    class="mb-2 block text-xs font-medium text-[#5F5953]"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 text-sm text-[#2C2926] outline-none focus:border-[#7B1E2B]"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="pending"
                        @selected(request('status') === 'pending')
                    >
                        Pending
                    </option>

                    <option
                        value="approved"
                        @selected(request('status') === 'approved')
                    >
                        Approved
                    </option>

                    <option
                        value="ongoing"
                        @selected(request('status') === 'ongoing')
                    >
                        Ongoing
                    </option>

                    <option
                        value="completed"
                        @selected(request('status') === 'completed')
                    >
                        Completed
                    </option>

                    <option
                        value="rejected"
                        @selected(request('status') === 'rejected')
                    >
                        Rejected
                    </option>

                    <option
                        value="cancelled"
                        @selected(request('status') === 'cancelled')
                    >
                        Cancelled
                    </option>

                </select>

            </div>


            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="rounded-xl bg-[#7B1E2B] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#651722]"
                >
                    Filter
                </button>

                @if(request()->hasAny(['search', 'status']))

                    <a
                        href="{{ route('admin.rentals.index') }}"
                        class="rounded-xl border border-[#DCCFC3] px-5 py-3 text-sm font-medium text-[#5F5953] hover:border-[#7B1E2B] hover:text-[#7B1E2B]"
                    >
                        Reset
                    </a>

                @endif

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-[#E7E0D6] bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full text-left">

                <thead class="border-b border-[#E7E0D6] bg-[#FBF9F5]">

                    <tr>

                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-[#8C847B]">
                            Penyewa
                        </th>

                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-[#8C847B]">
                            Kostum
                        </th>

                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-[#8C847B]">
                            Jumlah
                        </th>

                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-[#8C847B]">
                            Periode
                        </th>

                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-[#8C847B]">
                            Status
                        </th>

                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wide text-[#8C847B]">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#E7E0D6]">

                    @forelse ($rentals as $rental)

                        @php

                            $statusClasses = match ($rental->status) {

                                'pending' =>
                                    'bg-[#FFF4D6] text-[#8A6200]',

                                'approved' =>
                                    'bg-[#E8F5E9] text-[#2E7D32]',

                                'ongoing' =>
                                    'bg-[#E3F2FD] text-[#1565C0]',

                                'completed' =>
                                    'bg-[#EEEEEE] text-[#616161]',

                                'rejected' =>
                                    'bg-[#FDECEC] text-[#B3261E]',

                                'cancelled' =>
                                    'bg-[#F5F5F5] text-[#757575]',

                                default =>
                                    'bg-[#F5F5F5] text-[#757575]',
                            };


                            $statusLabel = match ($rental->status) {

                                'pending' => 'Pending',

                                'approved' => 'Approved',

                                'ongoing' => 'Sedang Disewa',

                                'completed' => 'Selesai',

                                'rejected' => 'Ditolak',

                                'cancelled' => 'Dibatalkan',

                                default => ucfirst($rental->status),
                            };

                        @endphp


                        <tr class="transition hover:bg-[#FBF9F5]">

                            {{-- Penyewa --}}
                            <td class="px-5 py-5">

                                <div class="font-medium text-[#2C2926]">
                                    {{ $rental->customer_name }}
                                </div>

                                <div class="mt-1 text-xs text-[#8C847B]">
                                    {{ $rental->team_name }}
                                </div>

                                <div class="mt-1 text-xs text-[#8C847B]">
                                    {{ $rental->phone }}
                                </div>

                            </td>


                            {{-- Kostum --}}
                            <td class="px-5 py-5">

                                <span class="font-semibold text-[#7B1E2B]">
                                    {{ $rental->costume_code }}
                                </span>

                            </td>


                            {{-- Jumlah --}}
                            <td class="px-5 py-5">

                                <span class="font-semibold text-[#2C2926]">
                                    {{ $rental->quantity }}
                                </span>

                                <span class="text-xs text-[#8C847B]">
                                    set
                                </span>

                            </td>


                            {{-- Periode --}}
                            <td class="px-5 py-5 whitespace-nowrap">

                                <div class="text-sm text-[#2C2926]">
                                    {{ $rental->rental_start?->format('d M Y') }}
                                </div>

                                <div class="mt-1 text-xs text-[#8C847B]">
                                    s/d {{ $rental->rental_end?->format('d M Y') }}
                                </div>

                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-5">

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>

                            </td>


                            {{-- Aksi --}}
                            <td class="px-5 py-5">

                                <a
                                    href="{{ route('admin.rentals.show', $rental) }}"
                                    class="inline-flex items-center rounded-lg border border-[#DCCFC3] px-3 py-2 text-xs font-medium text-[#5F5953] transition hover:border-[#7B1E2B] hover:text-[#7B1E2B]"
                                >
                                    Lihat Detail
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-16 text-center"
                            >

                                <div class="mx-auto max-w-sm">

                                    <p class="text-sm font-medium text-[#5F5953]">
                                        Belum ada pengajuan sewa.
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#9B9187]">
                                        Pengajuan penyewaan dari pengguna akan muncul di halaman ini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($rentals->hasPages())

            <div class="border-t border-[#E7E0D6] px-5 py-4">
                {{ $rentals->links() }}
            </div>

        @endif

    </div>

</div>

@endsection