<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-8">

    <p class="text-sm text-[#8C847B]">
        Selamat datang kembali,
    </p>

    <h2 class="mt-1 text-2xl font-semibold tracking-tight text-[#2C2926] sm:text-3xl">
        <?php echo e(auth()->user()->name ?? 'Administrator'); ?>.
    </h2>

    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#766E66]">
        Pantau koleksi kostum, ketersediaan set, dan pengajuan sewa
        Sebajar.id dari satu tempat.
    </p>

</div>

<section class="mb-6 flex flex-col gap-4 rounded-2xl border p-5 sm:flex-row sm:items-center sm:justify-between <?php echo e($rentalStatus['is_open'] ? 'border-[#CFE8D5] bg-[#F3FAF4]' : 'border-[#F1D2D2] bg-[#FFF7F6]'); ?>">
    <div class="flex items-start gap-3"><span class="mt-0.5 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full <?php echo e($rentalStatus['is_open'] ? 'bg-[#DFF2E3] text-[#39704B]' : 'bg-[#F9E0E0] text-[#9A303A]'); ?>"><?php echo e($rentalStatus['is_open'] ? '✓' : '!'); ?></span><div><h3 class="font-semibold text-[#332E2A]">Penyewaan <?php echo e($rentalStatus['is_open'] ? 'sedang dibuka' : 'sedang ditutup'); ?></h3><p class="mt-1 text-xs text-[#766E66]"><?php echo e($rentalStatus['automatic'] ? 'Mode otomatis aktif' : 'Mode manual aktif'); ?><?php if($rentalStatus['next_change']): ?> · Perubahan berikutnya <?php echo e($rentalStatus['next_change_label']); ?><?php endif; ?></p></div></div>
    <div class="flex flex-wrap gap-2"><a href="<?php echo e(route('admin.rentals.index')); ?>" class="rounded-xl border border-[#DCCFC3] bg-white px-4 py-2.5 text-xs font-semibold text-[#5F5953] hover:border-[#7B1E2B] hover:text-[#7B1E2B]"><?php echo e($pendingRentals); ?> pengajuan baru</a><a href="<?php echo e(route('admin.settings.edit')); ?>" class="rounded-xl bg-[#7B1E2B] px-4 py-2.5 text-xs font-semibold text-white hover:bg-[#681924]">Atur jam sewa</a></div>
</section>
            
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                
                <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-[0_4px_20px_rgba(61,45,35,0.04)]">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-[#8C847B]">
                                Kostum Aktif
                            </p>

                            <p class="mt-2 text-3xl font-semibold tracking-tight text-[#2C2926]">
                                <?php echo e($totalCostumes); ?>

                            </p>

                            <p class="mt-1 text-xs text-[#A39A90]">
                                Koleksi tersedia
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F6E9EA] text-[#7B1E2B]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m0 10V11"/>
                            </svg>
                        </div>

                    </div>

                </div>


                
                <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-[0_4px_20px_rgba(61,45,35,0.04)]">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-[#8C847B]">
                                Total Set
                            </p>

                            <p class="mt-2 text-3xl font-semibold tracking-tight text-[#2C2926]">
                                <?php echo e($totalSets); ?>

                            </p>

                            <p class="mt-1 text-xs text-[#A39A90]">
                                Baju + celana
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F3EEE6] text-[#806C59]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 7h16M4 12h16M4 17h16"/>
                            </svg>
                        </div>

                    </div>

                </div>


                
                <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-[0_4px_20px_rgba(61,45,35,0.04)]">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-[#8C847B]">
                                Pengajuan Baru
                            </p>

                            <p class="mt-2 text-3xl font-semibold tracking-tight text-[#2C2926]">
                                <?php echo e($pendingRentals); ?>

                            </p>

                            <p class="mt-1 text-xs text-[#A39A90]">
                                Menunggu diproses
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F8F0DF] text-[#9A6A1E]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                    </div>

                </div>


                
                <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-[0_4px_20px_rgba(61,45,35,0.04)]">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm text-[#8C847B]">
                                Sewa Aktif
                            </p>

                            <p class="mt-2 text-3xl font-semibold tracking-tight text-[#2C2926]">
                                <?php echo e($activeRentals); ?>

                            </p>

                            <p class="mt-1 text-xs text-[#A39A90]">
                                Telah disetujui
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E8F1EA] text-[#3E7350]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                    </div>

                </div>

            </div>


            
            <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

                
                <section class="overflow-hidden rounded-2xl border border-[#E7E0D6] bg-white">

                    <div class="flex items-center justify-between border-b border-[#EDE7DF] px-5 py-5 sm:px-6">

                        <div>
                            <h3 class="font-semibold text-[#332E2A]">
                                Pengajuan Sewa Terbaru
                            </h3>

                            <p class="mt-1 text-xs text-[#9B9187]">
                                Aktivitas pengajuan rental terbaru
                            </p>
                        </div>

                        <span class="rounded-full bg-[#F7F0EA] px-3 py-1 text-xs font-medium text-[#7B1E2B]">
                            <?php echo e($recentRentals->count()); ?> terbaru
                        </span>

                    </div>


                    <?php if($recentRentals->isEmpty()): ?>

                        <div class="px-6 py-12 text-center">

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#F5F0E9] text-[#9B9187]">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8 7V3m8 4V3M4 10h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                                </svg>
                            </div>

                            <p class="mt-3 text-sm font-medium text-[#514A44]">
                                Belum ada pengajuan sewa
                            </p>

                            <p class="mt-1 text-xs text-[#9B9187]">
                                Pengajuan baru akan muncul di sini.
                            </p>

                        </div>

                    <?php else: ?>

                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[680px] text-left">

                                <thead>
                                <tr class="border-b border-[#EDE7DF] bg-[#FCFAF7]">

                                    <th class="px-6 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9B9187]">
                                        Penyewa
                                    </th>

                                    <th class="px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9B9187]">
                                        Kostum
                                    </th>

                                    <th class="px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9B9187]">
                                        Jumlah
                                    </th>

                                    <th class="px-4 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9B9187]">
                                        Periode
                                    </th>

                                    <th class="px-6 py-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9B9187]">
                                        Status
                                    </th>

                                </tr>
                                </thead>

                                <tbody class="divide-y divide-[#F0EBE4]">

                                <?php $__currentLoopData = $recentRentals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr class="transition hover:bg-[#FCFAF7]">

                                        <td class="px-6 py-4">

                                            <p class="text-sm font-medium text-[#332E2A]">
                                                <?php echo e($rental->customer_name); ?>

                                            </p>

                                            <p class="mt-0.5 text-xs text-[#9B9187]">
                                                <?php echo e($rental->team_name); ?>

                                            </p>

                                        </td>

                                        <td class="px-4 py-4">

                                            <p class="text-sm font-medium text-[#514A44]">
                                                <?php echo e($rental->costume_code); ?>

                                            </p>

                                        </td>

                                        <td class="px-4 py-4 text-sm text-[#514A44]">
                                            <?php echo e($rental->quantity); ?> set
                                        </td>

                                        <td class="px-4 py-4">

                                            <p class="text-xs text-[#514A44]">
                                                <?php echo e(optional($rental->rental_start)->format('d M Y')); ?>

                                            </p>

                                            <p class="mt-0.5 text-xs text-[#9B9187]">
                                                s/d <?php echo e(optional($rental->rental_end)->format('d M Y')); ?>

                                            </p>

                                        </td>

                                        <td class="px-6 py-4">

                                            <?php
                                                $statusClasses = [
                                                    'pending' => 'bg-[#FFF4DC] text-[#966A1B]',
                                                    'approved' => 'bg-[#E8F4EB] text-[#39704B]',
                                                    'rejected' => 'bg-[#FBE9E9] text-[#A33E3E]',
                                                    'completed' => 'bg-[#EDEDED] text-[#5E5E5E]',
                                                ];

                                                $statusLabels = [
                                                    'pending' => 'Menunggu',
                                                    'approved' => 'Disetujui',
                                                    'rejected' => 'Ditolak',
                                                    'completed' => 'Selesai',
                                                ];
                                            ?>

                                            <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold <?php echo e($statusClasses[$rental->status] ?? 'bg-gray-100 text-gray-600'); ?>">
                                                <?php echo e($statusLabels[$rental->status] ?? ucfirst($rental->status)); ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>

                            </table>

                        </div>

                    <?php endif; ?>

                </section>


                
                <div class="space-y-6">

                    
                    <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6">

                        <div>
                            <h3 class="font-semibold text-[#332E2A]">
                                Ringkasan Rental
                            </h3>

                            <p class="mt-1 text-xs text-[#9B9187]">
                                Status pengajuan saat ini
                            </p>
                        </div>

                        <div class="mt-6 space-y-4">

                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <span class="h-2.5 w-2.5 rounded-full bg-[#D49B35]"></span>

                                    <span class="text-sm text-[#655D56]">
                                        Menunggu
                                    </span>

                                </div>

                                <span class="text-sm font-semibold text-[#332E2A]">
                                    <?php echo e($pendingRentals); ?>

                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <span class="h-2.5 w-2.5 rounded-full bg-[#4F8B62]"></span>

                                    <span class="text-sm text-[#655D56]">
                                        Disetujui
                                    </span>

                                </div>

                                <span class="text-sm font-semibold text-[#332E2A]">
                                    <?php echo e($activeRentals); ?>

                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <span class="h-2.5 w-2.5 rounded-full bg-[#8A8A8A]"></span>

                                    <span class="text-sm text-[#655D56]">
                                        Selesai
                                    </span>

                                </div>

                                <span class="text-sm font-semibold text-[#332E2A]">
                                    <?php echo e($completedRentals); ?>

                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <span class="h-2.5 w-2.5 rounded-full bg-[#B94A4A]"></span>

                                    <span class="text-sm text-[#655D56]">
                                        Ditolak
                                    </span>

                                </div>

                                <span class="text-sm font-semibold text-[#332E2A]">
                                    <?php echo e($rejectedRentals); ?>

                                </span>

                            </div>

                        </div>

                    </section>


                    
                    <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6">

                        <div class="flex items-start justify-between">

                            <div>
                                <h3 class="font-semibold text-[#332E2A]">
                                    Stok Menipis
                                </h3>

                                <p class="mt-1 text-xs text-[#9B9187]">
                                    Maksimal 5 set tersedia
                                </p>
                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#FFF4DC] text-[#966A1B]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v4m0 4h.01M10.3 3.8L2.7 17a2 2 0 001.73 3h15.14a2 2 0 001.73-3L13.7 3.8a2 2 0 00-3.4 0z"/>
                                </svg>
                            </div>

                        </div>


                        <div class="mt-5 space-y-3">

                            <?php $__empty_1 = true; $__currentLoopData = $lowStockCostumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <?php
                                    $baju = $costume->sizes
                                        ->where('category', 'baju')
                                        ->sum('quantity');

                                    $celana = $costume->sizes
                                        ->where('category', 'celana')
                                        ->sum('quantity');

                                    $sets = min($baju, $celana);
                                ?>

                                <div class="flex items-center gap-3 rounded-xl border border-[#EEE8E0] p-3">

                                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-lg bg-[#F3EEE7]">

                `                          <?php if($costume->image_url): ?>
                                                <img
                                                    src="<?php echo e($costume->image_url); ?>"
                                                    alt="<?php echo e($costume->name); ?>"
                                                    class="h-full w-full object-cover"
                                                >
                                            <?php else: ?>
                                                <div class="flex h-full w-full items-center justify-center bg-[#F1ECE5]">
                                                    <span class="text-xs text-[#9B9187]">
                                                        Tidak ada gambar
                                                    </span>
                                                </div>
                                            <?php endif; ?>

                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <p class="truncate text-sm font-semibold text-[#443D37]">
                                            <?php echo e($costume->code); ?>

                                        </p>

                                        <p class="truncate text-xs text-[#9B9187]">
                                            <?php echo e($costume->name); ?>

                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p class="text-sm font-semibold <?php echo e($sets <= 2 ? 'text-[#A33E3E]' : 'text-[#966A1B]'); ?>">
                                            <?php echo e($sets); ?>

                                        </p>

                                        <p class="text-[10px] uppercase tracking-wide text-[#A39A90]">
                                            set
                                        </p>

                                    </div>

                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <div class="rounded-xl bg-[#F7F4EF] p-4 text-center">

                                    <p class="text-sm font-medium text-[#514A44]">
                                        Semua stok aman
                                    </p>

                                    <p class="mt-1 text-xs text-[#9B9187]">
                                        Belum ada kostum dengan stok menipis.
                                    </p>

                                </div>

                            <?php endif; ?>

                        </div>

                    </section>

                </div>

            </div>


            
            <div class="mt-8 flex flex-col gap-2 border-t border-[#E7E0D6] pt-5 text-xs text-[#A39A90] sm:flex-row sm:items-center sm:justify-between">

                <p>
                    Sebajar.id Admin Panel
                </p>

                <p>
                    <?php echo e(now()->format('Y')); ?> · Rental Kostum Tari
                </p>

            </div>

        </div>

    </main>

</div>

</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>