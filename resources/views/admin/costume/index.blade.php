@extends('layouts.admin')

@section('title', 'Kostum')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Kostum
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola koleksi kostum dan ketersediaan set Sebajar.id.
            </p>
        </div>

        <a
            href="{{ route('admin.costumes.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#7B1E2B] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[#641722]"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            Tambah Kostum
        </a>

    </div>


    {{-- Search & Filter --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4">

        <form
            method="GET"
            action="{{ route('admin.costumes.index') }}"
            class="grid gap-3 md:grid-cols-[1fr_auto_auto]"
        >

            <div class="relative">

                <svg
                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"
                    />
                </svg>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kode atau nama kostum..."
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-4 text-sm text-gray-700 outline-none transition focus:border-[#7B1E2B] focus:bg-white focus:ring-2 focus:ring-[#7B1E2B]/10"
                >

            </div>


            <select
                name="status"
                class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
            >

                <option value="">
                    Semua Status
                </option>

                <option
                    value="active"
                    @selected(request('status') === 'active')
                >
                    Aktif
                </option>

                <option
                    value="inactive"
                    @selected(request('status') === 'inactive')
                >
                    Nonaktif
                </option>

            </select>


            <button
                type="submit"
                class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Filter
            </button>

        </form>

    </div>


    {{-- Flash Message --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>

    @endif


    {{-- Costume Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="border-b border-gray-200 bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Kostum
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Komponen
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Stok Set
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($costumes as $costume)

                        @php

                            $baju = $costume->sizes
                                ->where('category', 'baju')
                                ->sum('quantity');

                            $celana = $costume->sizes
                                ->where('category', 'celana')
                                ->sum('quantity');

                            $totalSets = min($baju, $celana);

                        @endphp


                        <tr class="transition hover:bg-gray-50">

                            {{-- Costume --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    <div class="h-14 w-14 shrink-0 overflow-hidden rounded-lg bg-gray-100">

                                        @if ($costume->image_url)

                                            <img
                                                src="{{ $costume->image_url }}"
                                                alt="{{ $costume->name }}"
                                                class="h-full w-full object-cover"
                                                loading="lazy"
                                            >

                                        @else

                                            <div class="flex h-full w-full items-center justify-center bg-[#F1ECE5]">
                                                <span class="text-sm text-[#9B9187]">
                                                    Tidak ada gambar
                                                </span>
                                            </div>

                                        @endif



                                    </div>


                                    <div>

                                        <p class="font-semibold text-gray-900">
                                            {{ $costume->code }}
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $costume->name }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Components --}}
                            <td class="px-4 py-4">

                                <div class="flex flex-wrap gap-1.5">

                                    <span class="rounded-md bg-gray-100 px-2 py-1 text-xs text-gray-600">
                                        Baju
                                    </span>

                                    <span class="rounded-md bg-gray-100 px-2 py-1 text-xs text-gray-600">
                                        Celana
                                    </span>

                                </div>

                            </td>


                            {{-- Stock --}}
                            <td class="px-4 py-4">

                                <div>

                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $totalSets }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        set tersedia
                                    </p>

                                </div>

                            </td>


                            {{-- Status --}}
                            <td class="px-4 py-4">

                                @if($costume->status === 'active')

                                    <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Aktif
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('admin.costumes.show', $costume) }}"
                                        class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
                                    >
                                        Detail
                                    </a>


                                    <a
                                        href="{{ route('admin.costumes.edit', $costume) }}"
                                        class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.costumes.destroy', $costume) }}"
                                        onsubmit="return confirm('Hapus kostum {{ addslashes($costume->code) }} - {{ addslashes($costume->name) }}?

Data stok dan gambar upload kostum ini akan ikut dihapus.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto max-w-sm">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">

                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m0 10V11"
                                            />
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-gray-900">
                                        Belum ada kostum
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Tambahkan koleksi kostum pertama Anda.
                                    </p>

                                    <a
                                        href="{{ route('admin.costumes.create') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-lg bg-[#7B1E2B] px-4 py-2 text-sm font-medium text-white hover:bg-[#641722]"
                                    >
                                        Tambah Kostum
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if(method_exists($costumes, 'links'))

            <div class="border-t border-gray-200 px-6 py-4">
                {{ $costumes->links() }}
            </div>

        @endif

    </div>

</div>

@endsection
