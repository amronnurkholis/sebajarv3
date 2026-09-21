<?php $__env->startSection('title', 'Pengajuan Sewa'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    
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


    
    <?php if(session('success')): ?>

        <div class="rounded-xl border border-[#CFE3D1] bg-[#EEF8EF] px-5 py-4 text-sm text-[#2E7D32]">
            <?php echo e(session('success')); ?>

        </div>

    <?php endif; ?>


    <?php if(session('error')): ?>

        <div class="rounded-xl border border-[#F0CACA] bg-[#FDF0F0] px-5 py-4 text-sm text-[#B3261E]">
            <?php echo e(session('error')); ?>

        </div>

    <?php endif; ?>


    
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

            <p class="text-xs font-medium uppercase tracking-wide text-[#8C847B]">
                Menunggu
            </p>

            <p class="mt-2 text-3xl font-semibold text-[#7B1E2B]">
                <?php echo e($pendingCount); ?>

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
                <?php echo e($rentals->total()); ?>

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
                <?php echo e(\App\Models\Rental::where('status', 'ongoing')->count()); ?>

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
                <?php echo e(\App\Models\Rental::where('status', 'completed')->count()); ?>

            </p>

            <p class="mt-1 text-xs text-[#9B9187]">
                Rental selesai
            </p>

        </div>

    </div>


    
    <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">

        <form
            method="GET"
            action="<?php echo e(route('admin.rentals.index')); ?>"
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
                    value="<?php echo e(request('search')); ?>"
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
                        <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>
                    >
                        Pending
                    </option>

                    <option
                        value="approved"
                        <?php if(request('status') === 'approved'): echo 'selected'; endif; ?>
                    >
                        Approved
                    </option>

                    <option
                        value="ongoing"
                        <?php if(request('status') === 'ongoing'): echo 'selected'; endif; ?>
                    >
                        Ongoing
                    </option>

                    <option
                        value="completed"
                        <?php if(request('status') === 'completed'): echo 'selected'; endif; ?>
                    >
                        Completed
                    </option>

                    <option
                        value="rejected"
                        <?php if(request('status') === 'rejected'): echo 'selected'; endif; ?>
                    >
                        Rejected
                    </option>

                    <option
                        value="cancelled"
                        <?php if(request('status') === 'cancelled'): echo 'selected'; endif; ?>
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

                <?php if(request()->hasAny(['search', 'status'])): ?>

                    <a
                        href="<?php echo e(route('admin.rentals.index')); ?>"
                        class="rounded-xl border border-[#DCCFC3] px-5 py-3 text-sm font-medium text-[#5F5953] hover:border-[#7B1E2B] hover:text-[#7B1E2B]"
                    >
                        Reset
                    </a>

                <?php endif; ?>

            </div>

        </form>

    </div>


    
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

                    <?php $__empty_1 = true; $__currentLoopData = $rentals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

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


                        <tr class="transition hover:bg-[#FBF9F5]">

                            
                            <td class="px-5 py-5">

                                <div class="font-medium text-[#2C2926]">
                                    <?php echo e($rental->customer_name); ?>

                                </div>

                                <div class="mt-1 text-xs text-[#8C847B]">
                                    <?php echo e($rental->team_name); ?>

                                </div>

                                <div class="mt-1 text-xs text-[#8C847B]">
                                    <?php echo e($rental->phone); ?>

                                </div>

                            </td>


                            
                            <td class="px-5 py-5">

                                <span class="font-semibold text-[#7B1E2B]">
                                    <?php echo e($rental->costume_code); ?>

                                </span>

                            </td>


                            
                            <td class="px-5 py-5">

                                <span class="font-semibold text-[#2C2926]">
                                    <?php echo e($rental->quantity); ?>

                                </span>

                                <span class="text-xs text-[#8C847B]">
                                    set
                                </span>

                            </td>


                            
                            <td class="px-5 py-5 whitespace-nowrap">

                                <div class="text-sm text-[#2C2926]">
                                    <?php echo e($rental->rental_start?->format('d M Y')); ?>

                                </div>

                                <div class="mt-1 text-xs text-[#8C847B]">
                                    s/d <?php echo e($rental->rental_end?->format('d M Y')); ?>

                                </div>

                            </td>


                            
                            <td class="px-5 py-5">

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium <?php echo e($statusClasses); ?>">
                                    <?php echo e($statusLabel); ?>

                                </span>

                            </td>


                            
                            <td class="px-5 py-5">

                                <a
                                    href="<?php echo e(route('admin.rentals.show', $rental)); ?>"
                                    class="inline-flex items-center rounded-lg border border-[#DCCFC3] px-3 py-2 text-xs font-medium text-[#5F5953] transition hover:border-[#7B1E2B] hover:text-[#7B1E2B]"
                                >
                                    Lihat Detail
                                </a>

                            </td>

                        </tr>


                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

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

                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        
        <?php if($rentals->hasPages()): ?>

            <div class="border-t border-[#E7E0D6] px-5 py-4">
                <?php echo e($rentals->links()); ?>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/rentals/index.blade.php ENDPATH**/ ?>