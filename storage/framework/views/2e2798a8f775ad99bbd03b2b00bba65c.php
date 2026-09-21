<?php $__env->startSection('title', 'Pengguna'); ?>
<?php $__env->startSection('page-title', 'Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <?php if(session('success')): ?>
        <div class="rounded-xl border border-[#D9E9D8] bg-[#F3FAF2] px-4 py-3 text-sm text-[#356333]"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="rounded-xl border border-[#F0D4D4] bg-[#FFF5F5] px-4 py-3 text-sm text-[#8B2933]"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm text-[#8C847B]">Kelola akun yang dapat mengakses Sebajar.id.</p>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#7B1E2B] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#681924]">
            <span class="text-lg leading-none">+</span> Tambah Pengguna
        </a>
    </div>

    <section class="overflow-hidden rounded-2xl border border-[#E7E0D6] bg-white">
        <div class="border-b border-[#E7E0D6] px-5 py-4 sm:px-6">
            <h2 class="font-semibold text-[#332E2A]">Daftar Pengguna</h2>
            <p class="mt-1 text-xs text-[#9B9187]"><?php echo e($users->total()); ?> akun terdaftar.</p>
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#FBF9F5] text-xs uppercase tracking-wide text-[#9B9187]">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Pengguna</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Terdaftar</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EEE8E0]">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-[#FCFAF7]">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#F1ECE5] font-semibold text-[#7B1E2B]"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
                                    <div><p class="font-medium text-[#332E2A]"><?php echo e($user->name); ?></p><p class="text-xs text-[#9B9187]">ID #<?php echo e($user->id); ?></p></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo e($user->role === 'admin' ? 'bg-[#F6E5E8] text-[#7B1E2B]' : 'bg-[#F1ECE5] text-[#655D56]'); ?>"><?php echo e($user->role === 'admin' ? 'Admin' : 'Customer'); ?></span>
                            </td>
                            <td class="px-6 py-4 text-[#655D56]"><?php echo e($user->created_at?->format('d M Y')); ?></td>
                            <td class="px-6 py-4"><div class="flex justify-end gap-2"><a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="rounded-lg border border-[#DCCFC3] px-3 py-2 text-xs font-semibold text-[#655D56] hover:bg-[#F8F5EF]">Edit</a><form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" onsubmit="return confirm('Hapus pengguna ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="rounded-lg px-3 py-2 text-xs font-semibold text-[#9A303A] hover:bg-[#FFF2F2]">Hapus</button></form></div></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-[#9B9187]">Belum ada pengguna.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="divide-y divide-[#EEE8E0] md:hidden">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#F1ECE5] font-semibold text-[#7B1E2B]"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
                        <div class="min-w-0 flex-1"><h3 class="font-semibold text-[#332E2A]"><?php echo e($user->name); ?></h3><p class="mt-1 text-xs text-[#9B9187]">Terdaftar <?php echo e($user->created_at?->format('d M Y')); ?></p><span class="mt-2 inline-block rounded-full px-2.5 py-1 text-[10px] font-semibold <?php echo e($user->role === 'admin' ? 'bg-[#F6E5E8] text-[#7B1E2B]' : 'bg-[#F1ECE5] text-[#655D56]'); ?>"><?php echo e($user->role === 'admin' ? 'Admin' : 'Customer'); ?></span></div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2"><a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="rounded-lg border border-[#DCCFC3] py-2.5 text-center text-xs font-semibold text-[#655D56]">Edit</a><form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" onsubmit="return confirm('Hapus pengguna ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="w-full rounded-lg bg-[#FFF2F2] py-2.5 text-xs font-semibold text-[#9A303A]">Hapus</button></form></div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-10 text-center text-sm text-[#9B9187]">Belum ada pengguna.</div>
            <?php endif; ?>
        </div>

        <?php if($users->hasPages()): ?>
            <div class="border-t border-[#E7E0D6] px-5 py-4"><?php echo e($users->links()); ?></div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/users/index.blade.php ENDPATH**/ ?>