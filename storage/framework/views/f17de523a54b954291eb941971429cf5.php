<?php $__env->startSection('title', 'Detail Kostum'); ?>
<?php $__env->startSection('page-title', 'Detail Kostum'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $gallery = collect();
    if ($costume->image) {
        $gallery->push([
            'url' => $costume->image_url,
            'path' => $costume->image,
            'order' => -1,
        ]);
    }
    foreach ($costume->images as $image) {
        $gallery->push([
            'url' => $image->image_url,
            'path' => $image->image_path,
            'order' => $image->sort_order,
        ]);
    }
    $gallery = $gallery->unique('path')->sortBy('order')->values();
    $firstImage = $gallery->first()['url'] ?? null;
    $baju = $costume->sizes->where('category', 'baju');
    $celana = $costume->sizes->where('category', 'celana');
    $totalSets = min($baju->sum('quantity'), $celana->sum('quantity'));
?>

<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <a href="<?php echo e(route('admin.costumes.index')); ?>" class="text-sm font-medium text-[#7B1E2B] hover:underline">← Kembali ke Inventori</a>
            <h2 class="mt-3 text-2xl font-semibold text-[#2C2926]"><?php echo e($costume->name); ?></h2>
            <p class="mt-1 text-sm text-[#8C847B]"><?php echo e($costume->code); ?></p>
        </div>
        <a href="<?php echo e(route('admin.costumes.edit', $costume)); ?>" class="rounded-lg bg-[#7B1E2B] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#641722]">Edit Kostum</a>
    </div>

    <section class="grid gap-6 lg:grid-cols-[1.1fr_.9fr]">
        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-5 shadow-sm">
            <?php if($firstImage): ?>
                <div class="aspect-[4/3] overflow-hidden rounded-xl bg-[#F1ECE5]">
                    <img id="adminMainImage" src="<?php echo e($firstImage); ?>" alt="<?php echo e($costume->name); ?>" class="h-full w-full object-cover">
                </div>
                <?php if($gallery->count() > 1): ?>
                    <div class="mt-3 grid grid-cols-4 gap-3 sm:grid-cols-5">
                        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="admin-gallery-thumb overflow-hidden rounded-lg border <?php echo e($loop->first ? 'border-[#7B1E2B]' : 'border-gray-200'); ?>" data-image="<?php echo e($image['url']); ?>">
                                <img src="<?php echo e($image['url']); ?>" alt="<?php echo e($costume->name); ?>" class="aspect-square w-full object-cover">
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="flex aspect-[4/3] items-center justify-center rounded-xl bg-[#F1ECE5] text-sm text-[#9B9187]">Tidak ada gambar</div>
            <?php endif; ?>
        </div>

        <div class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-[#2C2926]">Informasi Kostum</h3>
                <span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo e($costume->status === 'active' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600'); ?>">
                    <?php echo e($costume->status === 'active' ? 'Aktif' : 'Nonaktif'); ?>

                </span>
            </div>
            <dl class="mt-6 space-y-4 text-sm">
                <div><dt class="text-[#8C847B]">Kode</dt><dd class="mt-1 font-semibold text-[#2C2926]"><?php echo e($costume->code); ?></dd></div>
                <div><dt class="text-[#8C847B]">Nama</dt><dd class="mt-1 font-semibold text-[#2C2926]"><?php echo e($costume->name); ?></dd></div>
                <div><dt class="text-[#8C847B]">Deskripsi</dt><dd class="mt-1 whitespace-pre-line text-[#5F5953]"><?php echo e($costume->description ?: '-'); ?></dd></div>
                <div><dt class="text-[#8C847B]">Jumlah gambar</dt><dd class="mt-1 font-semibold text-[#2C2926]"><?php echo e($gallery->count()); ?></dd></div>
                <div><dt class="text-[#8C847B]">Stok set</dt><dd class="mt-1 text-2xl font-semibold text-[#7B1E2B]"><?php echo e($totalSets); ?> <span class="text-sm font-normal text-[#8C847B]">set</span></dd></div>
            </dl>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2">
        <?php $__currentLoopData = [['label'=>'Stok Baju','items'=>$baju],['label'=>'Stok Celana','items'=>$celana]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">
                <h3 class="font-semibold text-[#2C2926]"><?php echo e($group['label']); ?></h3>
                <div class="mt-4 divide-y divide-[#EEE8E0]">
                    <?php $__empty_1 = true; $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex justify-between py-3 text-sm"><span class="text-[#5F5953]"><?php echo e($item->size); ?></span><strong><?php echo e($item->quantity); ?> pcs</strong></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="py-3 text-sm text-[#9B9187]">Belum ada stok.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>
</div>

<script>
document.querySelectorAll('.admin-gallery-thumb').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('adminMainImage').src = button.dataset.image;
        document.querySelectorAll('.admin-gallery-thumb').forEach(item => item.classList.remove('border-[#7B1E2B]'));
        button.classList.add('border-[#7B1E2B]');
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/costume/show.blade.php ENDPATH**/ ?>