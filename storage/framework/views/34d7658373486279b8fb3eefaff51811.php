<?php $__env->startSection('title', 'Detail Pengajuan Sewa'); ?>

<?php $__env->startSection('content'); ?>

<div class="mx-auto max-w-5xl space-y-6">

    
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <a
                href="<?php echo e(route('admin.rentals.index')); ?>"
                class="text-sm text-[#8C847B] transition hover:text-[#7B1E2B]"
            >
                ← Kembali ke Pengajuan Sewa
            </a>

            <h1 class="mt-3 text-2xl font-semibold text-[#2C2926]">
                Detail Pengajuan Sewa
            </h1>

            <p class="mt-1 text-sm text-[#8C847B]">
                Informasi lengkap pengajuan penyewaan.
            </p>
        </div>

        
        <?php

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

        ?>

        <span
            class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-medium <?php echo e($statusClasses); ?>"
        >
            <?php echo e($statusLabel); ?>

        </span>

    </div>


    

    <?php if(session('success')): ?>

        <div
            class="rounded-xl border border-[#CFE3D1] bg-[#EEF8EF] px-5 py-4 text-sm text-[#2E7D32]"
        >
            <?php echo e(session('success')); ?>

        </div>

    <?php endif; ?>


    <?php if(session('error')): ?>

        <div
            class="rounded-xl border border-[#F0CACA] bg-[#FDF0F0] px-5 py-4 text-sm text-[#B3261E]"
        >
            <?php echo e(session('error')); ?>

        </div>

    <?php endif; ?>


    

    <div class="rounded-2xl border border-[#E7E0D6] bg-white shadow-sm">

        <div class="border-b border-[#E7E0D6] px-6 py-5">

            <h2 class="font-semibold text-[#2C2926]">
                Informasi Penyewa
            </h2>

        </div>


        <div class="grid gap-6 p-6 sm:grid-cols-2">

            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    Nama Penyewa
                </p>

                <p class="mt-2 text-sm font-medium text-[#2C2926]">
                    <?php echo e($rental->customer_name); ?>

                </p>

            </div>


            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    Nama Tim
                </p>

                <p class="mt-2 text-sm font-medium text-[#2C2926]">
                    <?php echo e($rental->team_name); ?>

                </p>

            </div>


            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    WhatsApp / Telepon
                </p>

                <p class="mt-2 text-sm font-medium text-[#2C2926]">
                    <?php echo e($rental->phone); ?>

                </p>

            </div>


            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    ID Pengajuan
                </p>

                <p class="mt-2 text-sm font-medium text-[#2C2926]">
                    #<?php echo e($rental->id); ?>

                </p>

            </div>

        </div>

    </div>


    

    <div class="rounded-2xl border border-[#E7E0D6] bg-white shadow-sm">

        <div class="border-b border-[#E7E0D6] px-6 py-5">

            <h2 class="font-semibold text-[#2C2926]">
                Detail Penyewaan
            </h2>

        </div>


        <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">

            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    Kode Kostum
                </p>

                <p class="mt-2 text-lg font-semibold text-[#7B1E2B]">
                    <?php echo e($rental->costume_code); ?>

                </p>

            </div>


            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    Jumlah Set
                </p>

                <p class="mt-2 text-lg font-semibold text-[#2C2926]">

                    <?php echo e($rental->quantity); ?>


                    <span class="text-sm font-normal text-[#8C847B]">
                        set
                    </span>

                </p>

            </div>


            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    Mulai Sewa
                </p>

                <p class="mt-2 text-sm font-medium text-[#2C2926]">

                    <?php echo e($rental->rental_start?->format('d M Y') ?? '-'); ?>


                </p>

            </div>


            
            <div>

                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#9B9187]"
                >
                    Pengembalian
                </p>

                <p class="mt-2 text-sm font-medium text-[#2C2926]">

                    <?php echo e($rental->rental_end?->format('d M Y') ?? '-'); ?>


                </p>

            </div>

        </div>

    </div>


    

    <?php

        /*
        |--------------------------------------------------------------------------
        | Pisahkan ukuran berdasarkan kategori
        |--------------------------------------------------------------------------
        */

        $shirtSizes = $rental->sizes
            ->where('category', 'baju')
            ->filter(fn ($size) => (int) $size->quantity > 0);

        $pantsSizes = $rental->sizes
            ->where('category', 'celana')
            ->filter(fn ($size) => (int) $size->quantity > 0);

    ?>


    <div class="rounded-2xl border border-[#E7E0D6] bg-white shadow-sm">

        <div class="border-b border-[#E7E0D6] px-6 py-5">

            <h2 class="font-semibold text-[#2C2926]">
                Ukuran yang Dipilih Penyewa
            </h2>

            <p class="mt-1 text-sm text-[#8C847B]">
                Menampilkan ukuran dan jumlah yang benar-benar dipilih
                saat pengajuan.
            </p>

        </div>


        <div class="grid gap-6 p-6 md:grid-cols-2">

            

            <div>

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-[#9B9187]">
                            Kategori
                        </p>

                        <h3 class="mt-1 text-lg font-semibold text-[#2C2926]">
                            Baju
                        </h3>

                    </div>

                    <span class="rounded-full bg-[#FBF9F5] px-3 py-1 text-xs font-medium text-[#7B1E2B]">

                        <?php echo e($shirtSizes->sum('quantity')); ?> set

                    </span>

                </div>


                <?php if($shirtSizes->isNotEmpty()): ?>

                    <div class="space-y-3">

                        <?php $__currentLoopData = $shirtSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div
                                class="flex items-center justify-between rounded-xl border border-[#E7E0D6] bg-[#FBF9F5] px-4 py-3"
                            >

                                <div>

                                    <p class="font-medium text-[#2C2926]">
                                        <?php echo e($size->size); ?>

                                    </p>

                                    <p class="text-xs text-[#8C847B]">
                                        Ukuran baju
                                    </p>

                                </div>


                                <div class="text-right">

                                    <p class="text-lg font-semibold text-[#7B1E2B]">
                                        <?php echo e($size->quantity); ?>

                                    </p>

                                    <p class="text-xs text-[#8C847B]">
                                        pcs
                                    </p>

                                </div>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php else: ?>

                    <div
                        class="rounded-xl bg-[#FBF9F5] px-4 py-4 text-sm text-[#8C847B]"
                    >
                        Tidak ada ukuran baju yang tersimpan.
                    </div>

                <?php endif; ?>

            </div>


            

            <div>

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-[#9B9187]">
                            Kategori
                        </p>

                        <h3 class="mt-1 text-lg font-semibold text-[#2C2926]">
                            Celana
                        </h3>

                    </div>

                    <span class="rounded-full bg-[#FBF9F5] px-3 py-1 text-xs font-medium text-[#7B1E2B]">

                        <?php echo e($pantsSizes->sum('quantity')); ?> set

                    </span>

                </div>


                <?php if($pantsSizes->isNotEmpty()): ?>

                    <div class="space-y-3">

                        <?php $__currentLoopData = $pantsSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div
                                class="flex items-center justify-between rounded-xl border border-[#E7E0D6] bg-[#FBF9F5] px-4 py-3"
                            >

                                <div>

                                    <p class="font-medium text-[#2C2926]">
                                        <?php echo e($size->size); ?>

                                    </p>

                                    <p class="text-xs text-[#8C847B]">
                                        Ukuran celana
                                    </p>

                                </div>


                                <div class="text-right">

                                    <p class="text-lg font-semibold text-[#7B1E2B]">
                                        <?php echo e($size->quantity); ?>

                                    </p>

                                    <p class="text-xs text-[#8C847B]">
                                        pcs
                                    </p>

                                </div>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php else: ?>

                    <div
                        class="rounded-xl bg-[#FBF9F5] px-4 py-4 text-sm text-[#8C847B]"
                    >
                        Tidak ada ukuran celana yang tersimpan.
                    </div>

                <?php endif; ?>

            </div>

        </div>


        
        <div class="border-t border-[#E7E0D6] px-6 py-4">

            <?php
                $shirtTotal = (int) $shirtSizes->sum('quantity');
                $pantsTotal = (int) $pantsSizes->sum('quantity');
                $requestedTotal = (int) $rental->quantity;
            ?>

            <div class="grid gap-3 sm:grid-cols-3">

                <div class="rounded-xl bg-[#FBF9F5] px-4 py-3">

                    <p class="text-xs text-[#8C847B]">
                        Jumlah Set
                    </p>

                    <p class="mt-1 font-semibold text-[#2C2926]">
                        <?php echo e($requestedTotal); ?> set
                    </p>

                </div>


                <div class="rounded-xl bg-[#FBF9F5] px-4 py-3">

                    <p class="text-xs text-[#8C847B]">
                        Total Baju
                    </p>

                    <p class="mt-1 font-semibold <?php echo e($shirtTotal === $requestedTotal ? 'text-[#2E7D32]' : 'text-[#B3261E]'); ?>">

                        <?php echo e($shirtTotal); ?> set

                    </p>

                </div>


                <div class="rounded-xl bg-[#FBF9F5] px-4 py-3">

                    <p class="text-xs text-[#8C847B]">
                        Total Celana
                    </p>

                    <p class="mt-1 font-semibold <?php echo e($pantsTotal === $requestedTotal ? 'text-[#2E7D32]' : 'text-[#B3261E]'); ?>">

                        <?php echo e($pantsTotal); ?> set

                    </p>

                </div>

            </div>

        </div>

    </div>


    

    <div class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">

        <h2 class="font-semibold text-[#2C2926]">
            Tindakan
        </h2>

        <p class="mt-1 text-sm text-[#8C847B]">
            Tindakan yang tersedia menyesuaikan status pengajuan.
        </p>


        <div class="mt-5 flex flex-wrap gap-3">

            

            <?php if($rental->status === 'pending'): ?>

                
                <form
                    method="POST"
                    action="<?php echo e(route('admin.rentals.approve', $rental)); ?>"
                    onsubmit="return confirm('Setujui pengajuan rental ini? Sistem akan mengecek kembali ketersediaan stok dan ukuran.');"
                >

                    <?php echo csrf_field(); ?>

                    <button
                        type="submit"
                        class="rounded-xl bg-[#2E7D32] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#256628]"
                    >
                        ✓ Setujui Pengajuan
                    </button>

                </form>


                
                <form
                    method="POST"
                    action="<?php echo e(route('admin.rentals.reject', $rental)); ?>"
                    onsubmit="return confirm('Tolak pengajuan rental ini?');"
                >

                    <?php echo csrf_field(); ?>

                    <button
                        type="submit"
                        class="rounded-xl border border-[#E0B8B8] bg-white px-5 py-3 text-sm font-medium text-[#B3261E] transition hover:bg-[#FDF0F0]"
                    >
                        ✕ Tolak Pengajuan
                    </button>

                </form>

            <?php endif; ?>


            

            <?php if($rental->status === 'approved'): ?>

                <form
                    method="POST"
                    action="<?php echo e(route('admin.rentals.complete', $rental)); ?>"
                    onsubmit="return confirm('Tandai penyewaan ini sebagai selesai? Gunakan tombol ini setelah kostum sudah dikembalikan.');"
                >

                    <?php echo csrf_field(); ?>

                    <button
                        type="submit"
                        class="rounded-xl bg-[#7B1E2B] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#651722]"
                    >
                        ✓ Selesaikan Penyewaan
                    </button>

                </form>


                <div
                    class="flex items-center rounded-xl bg-[#E8F5E9] px-4 py-3 text-sm text-[#2E7D32]"
                >
                    Pengajuan sudah disetujui.
                </div>

            <?php endif; ?>


            

            <?php if($rental->status === 'ongoing'): ?>

                <form
                    method="POST"
                    action="<?php echo e(route('admin.rentals.complete', $rental)); ?>"
                    onsubmit="return confirm('Pastikan kostum sudah dikembalikan. Tandai penyewaan sebagai selesai?');"
                >

                    <?php echo csrf_field(); ?>

                    <button
                        type="submit"
                        class="rounded-xl bg-[#7B1E2B] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#651722]"
                    >
                        ✓ Selesai & Kostum Dikembalikan
                    </button>

                </form>


                <div
                    class="flex items-center rounded-xl bg-[#E3F2FD] px-4 py-3 text-sm text-[#1565C0]"
                >
                    Kostum sedang disewa.
                </div>

            <?php endif; ?>


            

            <?php if($rental->status === 'completed'): ?>

                <div
                    class="rounded-xl bg-[#F5F5F5] px-5 py-3 text-sm text-[#616161]"
                >
                    Rental ini sudah selesai. Stok otomatis kembali tersedia
                    melalui sistem availability.
                </div>

            <?php endif; ?>


            

            <?php if($rental->status === 'rejected'): ?>

                <div
                    class="rounded-xl bg-[#FDF0F0] px-5 py-3 text-sm text-[#B3261E]"
                >
                    Pengajuan ini telah ditolak dan tidak menggunakan stok.
                </div>

            <?php endif; ?>


            

            <?php if($rental->status === 'cancelled'): ?>

                <div
                    class="rounded-xl bg-[#F5F5F5] px-5 py-3 text-sm text-[#757575]"
                >
                    Rental ini telah dibatalkan.
                </div>

            <?php endif; ?>

        </div>

    </div>


    

    <div
        class="rounded-xl border border-[#E7E0D6] bg-[#FBF9F5] px-5 py-4"
    >

        <p class="text-xs leading-5 text-[#8C847B]">

            <strong class="text-[#5F5953]">
                Catatan sistem:
            </strong>

            Stok fisik pada <code>costume_sizes</code> tidak diubah ketika
            rental disetujui. Sistem menghitung ketersediaan berdasarkan
            rental yang berstatus aktif dan ukuran yang benar-benar dipilih.
            Setelah rental selesai, stok kembali tersedia secara otomatis
            melalui sistem availability.

        </p>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/rentals/show.blade.php ENDPATH**/ ?>