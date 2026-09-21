<?php $__env->startSection('title', 'Tambah Pengguna'); ?>
<?php $__env->startSection('page-title', 'Tambah Pengguna'); ?>
<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-2xl">
    <div class="mb-6"><a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm font-medium text-[#7B1E2B]">← Kembali ke Pengguna</a></div>
    <form method="POST" action="<?php echo e(route('admin.users.store')); ?>" class="space-y-5 rounded-2xl border border-[#E7E0D6] bg-white p-5 sm:p-7">
        <?php echo csrf_field(); ?>
        <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Nama pengguna</label><input name="name" value="<?php echo e(old('name')); ?>" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm outline-none focus:border-[#7B1E2B]"><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#9A303A]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Role</label><select name="role" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm outline-none focus:border-[#7B1E2B]"><option value="customer" <?php if(old('role') === 'customer'): echo 'selected'; endif; ?>>Customer</option><option value="admin" <?php if(old('role') === 'admin'): echo 'selected'; endif; ?>>Admin</option></select></div>
        <div class="grid gap-5 sm:grid-cols-2"><div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Password</label><input type="password" name="password" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#9A303A]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div><div><label class="mb-2 block text-sm font-semibold text-[#332E2A]">Konfirmasi password</label><input type="password" name="password_confirmation" required class="w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div></div>
        <button class="w-full rounded-xl bg-[#7B1E2B] px-4 py-3 text-sm font-semibold text-white hover:bg-[#681924]">Simpan Pengguna</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/users/create.blade.php ENDPATH**/ ?>