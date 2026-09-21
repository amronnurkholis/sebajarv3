<?php $__env->startSection('title', 'Pengaturan'); ?>
<?php $__env->startSection('page-title', 'Pengaturan'); ?>
<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-3xl space-y-6">
    <?php if(session('success')): ?><div class="rounded-xl border border-[#D9E9D8] bg-[#F3FAF2] px-4 py-3 text-sm text-[#356333]"><?php echo e(session('success')); ?></div><?php endif; ?>
    <section class="rounded-2xl border border-[#E7E0D6] bg-white p-5 sm:p-7">
        <div class="mb-6"><h2 class="font-semibold text-[#332E2A]">Profil Admin</h2><p class="mt-1 text-xs text-[#9B9187]">Kelola nama akun yang digunakan untuk masuk ke dashboard.</p></div>
        <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Nama pengguna</label><input name="name" value="<?php echo e(old('name', $user->name)); ?>" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#9A303A]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="rounded-xl bg-[#FBF9F5] p-4"><h3 class="text-sm font-semibold text-[#332E2A]">Ganti password</h3><p class="mt-1 text-xs text-[#8C847B]">Isi bagian ini hanya jika password ingin diganti.</p><div class="mt-4 space-y-4"><div><label class="mb-2 block text-xs font-semibold text-[#655D56]">Password saat ini</label><input type="password" name="current_password" class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#9A303A]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div><div class="grid gap-4 sm:grid-cols-2"><div><label class="mb-2 block text-xs font-semibold text-[#655D56]">Password baru</label><input type="password" name="password" class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div><div><label class="mb-2 block text-xs font-semibold text-[#655D56]">Konfirmasi password</label><input type="password" name="password_confirmation" class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div></div><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#9A303A]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div></div>
            <button class="w-full rounded-xl bg-[#7B1E2B] px-4 py-3 text-sm font-semibold text-white hover:bg-[#681924]">Simpan Pengaturan</button>
        </form>
    </section>
    <section class="rounded-2xl border border-[#E7E0D6] bg-white p-5 sm:p-7">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-3"><div><h2 class="font-semibold text-[#332E2A]">Jam Operasional Penyewaan</h2><p class="mt-1 text-xs text-[#9B9187]">Atur waktu booking dan status buka/tutup layanan untuk pelanggan.</p></div><span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo e($rentalStatus['is_open'] ? 'bg-[#E8F3EB] text-[#356333]' : 'bg-[#FCE9E8] text-[#9A303A]'); ?>"><?php echo e($rentalStatus['is_open'] ? 'Penyewaan dibuka' : 'Penyewaan ditutup'); ?></span></div>
        <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <input type="hidden" name="name" value="<?php echo e($user->name); ?>">
            <div class="rounded-xl bg-[#FBF9F5] p-4"><label class="flex cursor-pointer items-center justify-between gap-4"><span><strong class="block text-sm text-[#332E2A]">Mode otomatis</strong><small class="mt-1 block text-xs text-[#8C847B]">Sistem membuka dan menutup penyewaan sesuai jam.</small></span><input type="checkbox" name="rental_automatic" value="1" <?php if(old('rental_automatic', $rentalSettings['automatic'])): echo 'checked'; endif; ?> class="h-5 w-5 accent-[#7B1E2B]"></label></div>
            <div class="grid gap-4 sm:grid-cols-2"><div><label class="mb-2 block text-xs font-semibold text-[#655D56]">Jam buka (WIB)</label><input type="time" name="rental_open_time" value="<?php echo e(old('rental_open_time', $rentalSettings['open_time'])); ?>" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div><div><label class="mb-2 block text-xs font-semibold text-[#655D56]">Jam tutup (WIB)</label><input type="time" name="rental_close_time" value="<?php echo e(old('rental_close_time', $rentalSettings['close_time'])); ?>" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div></div>
            <div class="rounded-xl border border-[#E7E0D6] p-4"><label class="flex cursor-pointer items-center justify-between gap-4"><span><strong class="block text-sm text-[#332E2A]">Buka manual</strong><small class="mt-1 block text-xs text-[#8C847B]">Dipakai saat mode otomatis dimatikan.</small></span><input type="checkbox" name="rental_manual_open" value="1" <?php if(old('rental_manual_open', $rentalSettings['manual_open'])): echo 'checked'; endif; ?> class="h-5 w-5 accent-[#7B1E2B]"></label></div>
            <div><label class="mb-2 block text-xs font-semibold text-[#655D56]">Pesan saat penyewaan ditutup</label><input name="rental_closed_message" value="<?php echo e(old('rental_closed_message', $rentalSettings['closed_message'])); ?>" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div>
            <button class="w-full rounded-xl bg-[#7B1E2B] px-4 py-3 text-sm font-semibold text-white hover:bg-[#681924]">Simpan Jadwal Penyewaan</button>
        </form>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>