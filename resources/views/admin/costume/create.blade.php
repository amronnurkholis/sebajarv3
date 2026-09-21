@extends('layouts.admin')

@section('title', 'Tambah Kostum')

@section('page-title', 'Tambah Kostum')

@section('content')

<div class="mx-auto max-w-5xl">

    {{-- Header --}}
    <div class="mb-6">

        <a
            href="{{ route('admin.costumes.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-[#7B1E2B] hover:underline"
        >
            <span>←</span>
            Kembali ke daftar kostum
        </a>

        <div class="mt-4">

            <h2 class="text-2xl font-semibold tracking-tight text-[#2C2926]">
                Tambah Kostum
            </h2>

            <p class="mt-1 text-sm text-[#8C847B]">
                Tambahkan kostum baru beserta gambar dan stok setiap komponennya.
            </p>

        </div>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="flex gap-3">

                <div class="mt-0.5 text-red-600">
                    ⚠
                </div>

                <div>

                    <p class="font-semibold text-red-800">
                        Data belum dapat disimpan.
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    <form
        action="{{ route('admin.costumes.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf


        {{-- =====================================================
             INFORMASI UTAMA
        ====================================================== --}}
        <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">

            <div class="border-b border-[#EEE8E0] pb-5">

                <h3 class="text-base font-semibold text-[#2C2926]">
                    Informasi Kostum
                </h3>

                <p class="mt-1 text-sm text-[#8C847B]">
                    Informasi dasar yang akan ditampilkan pada katalog admin.
                </p>

            </div>


            <div class="mt-6 grid gap-5 md:grid-cols-2">

                {{-- Kode --}}
                <div>

                    <label
                        for="code"
                        class="block text-sm font-medium text-[#5F5953]"
                    >
                        Kode Kostum
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="code"
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="Contoh: SBJ-019"
                        maxlength="50"
                        required
                        autofocus
                        class="mt-2 w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 text-sm text-[#332E2A] uppercase outline-none transition placeholder:text-[#B5ACA3] focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                    >

                    <p class="mt-1.5 text-xs text-[#9B9187]">
                        Gunakan kode unik untuk setiap kostum.
                    </p>

                </div>


                {{-- Nama --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-medium text-[#5F5953]"
                    >
                        Nama Kostum
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Magenta / Purple"
                        maxlength="150"
                        required
                        class="mt-2 w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 text-sm text-[#332E2A] outline-none transition placeholder:text-[#B5ACA3] focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                    >

                </div>


                {{-- Status --}}
                <div>

                    <label
                        for="status"
                        class="block text-sm font-medium text-[#5F5953]"
                    >
                        Status
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="mt-2 w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 text-sm text-[#332E2A] outline-none transition focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                    >

                        <option
                            value="active"
                            @selected(old('status', 'active') === 'active')
                        >
                            Aktif
                        </option>

                        <option
                            value="inactive"
                            @selected(old('status') === 'inactive')
                        >
                            Nonaktif
                        </option>

                    </select>

                </div>


                {{-- Gambar --}}
                <div>

                    <label
                        for="images"
                        class="block text-sm font-medium text-[#5F5953]"
                    >
                        Gambar Kostum
                    </label>

                    <input
                        id="images"
                        type="file"
                        name="images[]" multiple
                        accept="image/jpeg,image/png,image/webp"
                        class="mt-2 block w-full cursor-pointer rounded-xl border border-[#DCCFC3] bg-white text-sm text-[#5F5953] file:mr-4 file:cursor-pointer file:border-0 file:bg-[#F1ECE5] file:px-4 file:py-3 file:text-sm file:font-medium file:text-[#5F5953] hover:file:bg-[#EAE3D9]"
                    >

                    <p class="mt-1.5 text-xs text-[#9B9187]">
                        JPG, JPEG, PNG, WEBP — maksimal 5 MB per gambar. Maksimal 10 gambar.
                    </p>

                </div>

            </div>


            {{-- Description --}}
            <div class="mt-5">

                <label
                    for="description"
                    class="block text-sm font-medium text-[#5F5953]"
                >
                    Deskripsi
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Contoh: Kostum tari dengan kombinasi warna magenta dan purple..."
                    class="mt-2 w-full resize-y rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 text-sm text-[#332E2A] outline-none transition placeholder:text-[#B5ACA3] focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                >{{ old('description') }}</textarea>

            </div>

        </section>


        {{-- =====================================================
             STOK BAJU
        ====================================================== --}}
        <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">

            <div class="border-b border-[#EEE8E0] pb-5">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <h3 class="text-base font-semibold text-[#2C2926]">
                            Stok Baju
                        </h3>

                        <p class="mt-1 text-sm text-[#8C847B]">
                            Masukkan jumlah baju yang tersedia berdasarkan ukuran.
                        </p>

                    </div>

                    <span class="rounded-full bg-[#F7F0E9] px-3 py-1 text-xs font-medium text-[#7B1E2B]">
                        Komponen 1
                    </span>

                </div>

            </div>


            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ([
                    'All Size',
                    'S',
                    'M',
                    'L',
                    'XL',
                    'XXL',
                    'XXXL'
                ] as $size)

                    <div>

                        <label
                            for="baju_{{ \Illuminate\Support\Str::slug($size) }}"
                            class="block text-sm font-medium text-[#5F5953]"
                        >
                            {{ $size }}
                        </label>

                        <div class="relative mt-2">

                            <input
                                id="baju_{{ \Illuminate\Support\Str::slug($size) }}"
                                type="number"
                                name="baju[{{ $size }}]"
                                value="{{ old('baju.' . $size, 0) }}"
                                min="0"
                                step="1"
                                class="w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 pr-14 text-sm text-[#332E2A] outline-none transition focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                            >

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-[#9B9187]">
                                pcs
                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        </section>


        {{-- =====================================================
             STOK CELANA
        ====================================================== --}}
        <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">

            <div class="border-b border-[#EEE8E0] pb-5">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <h3 class="text-base font-semibold text-[#2C2926]">
                            Stok Celana
                        </h3>

                        <p class="mt-1 text-sm text-[#8C847B]">
                            Masukkan jumlah celana yang tersedia berdasarkan ukuran.
                        </p>

                    </div>

                    <span class="rounded-full bg-[#F7F0E9] px-3 py-1 text-xs font-medium text-[#7B1E2B]">
                        Komponen 2
                    </span>

                </div>

            </div>


            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ([
                    'All Size',
                    'S',
                    'M',
                    'L',
                    'XL',
                    'XXL',
                    'XXXL'
                ] as $size)

                    <div>

                        <label
                            for="celana_{{ \Illuminate\Support\Str::slug($size) }}"
                            class="block text-sm font-medium text-[#5F5953]"
                        >
                            {{ $size }}
                        </label>

                        <div class="relative mt-2">

                            <input
                                id="celana_{{ \Illuminate\Support\Str::slug($size) }}"
                                type="number"
                                name="celana[{{ $size }}]"
                                value="{{ old('celana.' . $size, 0) }}"
                                min="0"
                                step="1"
                                class="w-full rounded-xl border border-[#DCCFC3] bg-white px-4 py-3 pr-14 text-sm text-[#332E2A] outline-none transition focus:border-[#7B1E2B] focus:ring-2 focus:ring-[#7B1E2B]/10"
                            >

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-[#9B9187]">
                                pcs
                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        </section>


        {{-- =====================================================
             PREVIEW JUMLAH SET
        ====================================================== --}}
        <section class="rounded-2xl border border-[#E7E0D6] bg-[#FBF9F5] p-6">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-sm font-semibold text-[#2C2926]">
                        Perhitungan Set
                    </p>

                    <p class="mt-1 text-sm text-[#8C847B]">
                        Satu set terdiri dari satu baju dan satu celana.
                    </p>

                </div>


                <div class="text-left sm:text-right">

                    <p
                        id="set-preview"
                        class="text-3xl font-bold text-[#7B1E2B]"
                    >
                        0
                    </p>

                    <p class="text-xs text-[#9B9187]">
                        set maksimal
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             ACTION
        ====================================================== --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">

            <a
                href="{{ route('admin.costumes.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-[#DCCFC3] bg-white px-5 py-3 text-sm font-medium text-[#5F5953] transition hover:bg-[#F7F3EE]"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-[#7B1E2B] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#641722] focus:outline-none focus:ring-2 focus:ring-[#7B1E2B]/20"
            >
                Simpan Kostum
            </button>

        </div>

    </form>

</div>


{{-- =========================================================
     SET PREVIEW
========================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const bajuInputs = document.querySelectorAll(
        'input[name^="baju["]'
    );

    const celanaInputs = document.querySelectorAll(
        'input[name^="celana["]'
    );

    const preview = document.getElementById(
        'set-preview'
    );


    function calculateTotal(selector) {

        let total = 0;

        selector.forEach(function (input) {

            const value = parseInt(
                input.value,
                10
            );

            if (!Number.isNaN(value)) {
                total += value;
            }

        });

        return total;
    }


    function updatePreview() {

        const totalBaju = calculateTotal(
            bajuInputs
        );

        const totalCelana = calculateTotal(
            celanaInputs
        );

        const totalSet = Math.min(
            totalBaju,
            totalCelana
        );

        preview.textContent = totalSet;
    }


    bajuInputs.forEach(function (input) {
        input.addEventListener(
            'input',
            updatePreview
        );
    });


    celanaInputs.forEach(function (input) {
        input.addEventListener(
            'input',
            updatePreview
        );
    });


    updatePreview();

});
</script>

@endsection

