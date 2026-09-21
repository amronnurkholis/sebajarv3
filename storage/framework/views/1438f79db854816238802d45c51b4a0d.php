<?php $__env->startSection('title', 'Edit Kostum'); ?>
<?php $__env->startSection('page-title', 'Edit Kostum'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $baju = $costume->sizes->where('category', 'baju')->keyBy('size');
    $celana = $costume->sizes->where('category', 'celana')->keyBy('size');
    $gallery = $costume->images->map(fn ($image) => [
        'id' => $image->id,
        'path' => $image->image_path,
        'url' => $image->image_url,
        'sort_order' => $image->sort_order,
    ]);

    // Gambar lama/static tanpa record gallery tetap terlihat, tetapi tidak
    // diberi aksi hapus agar file shared tidak dapat ikut terhapus.
    if ($costume->image && !$gallery->contains('path', $costume->image)) {
        $gallery->prepend([
            'id' => null,
            'path' => $costume->image,
            'url' => $costume->image_url,
            'sort_order' => -1,
        ]);
    }

    $gallery = $gallery->sortBy('sort_order')->values();
?>

<div class="mx-auto max-w-5xl">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.costumes.index')); ?>" class="text-sm font-medium text-[#7B1E2B] hover:underline">← Kembali ke Inventori</a>
        <h2 class="mt-3 text-2xl font-semibold text-[#2C2926]">Edit Kostum</h2>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.costumes.update', $costume)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6" data-costume-edit-form>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">
            <h3 class="font-semibold text-[#2C2926]">Informasi Kostum</h3>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div><label class="text-sm font-medium text-[#5F5953]">Kode</label><input name="code" value="<?php echo e(old('code',$costume->code)); ?>" class="mt-2 w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div>
                <div><label class="text-sm font-medium text-[#5F5953]">Nama</label><input name="name" value="<?php echo e(old('name',$costume->name)); ?>" class="mt-2 w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div>
                <div><label class="text-sm font-medium text-[#5F5953]">Status</label><select name="status" class="mt-2 w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"><option value="active" <?php if(old('status',$costume->status)==='active'): echo 'selected'; endif; ?>>Aktif</option><option value="inactive" <?php if(old('status',$costume->status)==='inactive'): echo 'selected'; endif; ?>>Nonaktif</option></select></div>
            </div>
            <div class="mt-5"><label class="text-sm font-medium text-[#5F5953]">Deskripsi</label><textarea name="description" rows="4" class="mt-2 w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"><?php echo e(old('description',$costume->description)); ?></textarea></div>
        </section>

        <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">
            <h3 class="font-semibold text-[#2C2926]">Gambar Kostum</h3>
            <?php if($gallery->count()): ?>
                <div class="mt-4 grid grid-cols-3 gap-3 sm:grid-cols-5">
                    <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group relative overflow-hidden rounded-lg border border-gray-200 bg-[#F8F5EF]">
                            <img src="<?php echo e($image['url']); ?>" alt="<?php echo e($costume->name); ?>" class="aspect-square w-full object-cover">
                            <?php if($image['id']): ?>
                                
                                <button type="submit"
                                        form="delete-costume-image-<?php echo e($image['id']); ?>"
                                        class="absolute right-1.5 top-1.5 rounded-md bg-white/95 p-1.5 text-[#9A303A] shadow-sm transition hover:bg-[#FFF2F2] focus:outline-none focus:ring-2 focus:ring-[#7B1E2B]"
                                        aria-label="Hapus gambar"
                                        onclick="return confirm('Hapus gambar ini dari galeri kostum?')">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7m-7.5 0 .6 12.1A2 2 0 0 0 10.1 21h3.8a2 2 0 0 0 2-1.9L16.5 7M10 11v6m4-6v6"/></svg>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <input id="images" type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="mt-5 block w-full cursor-pointer rounded-xl border border-[#DCCFC3] bg-white text-sm file:mr-4 file:border-0 file:bg-[#F1ECE5] file:px-4 file:py-3">
            <p class="mt-2 text-xs text-[#9B9187]">Pilih satu atau beberapa gambar baru. Gambar baru akan ditambahkan ke galeri, bukan menghapus gambar lama. Maksimal 10 gambar per upload, 5 MB per gambar.</p>
        </section>

        <?php $__currentLoopData = [['key'=>'baju','title'=>'Stok Baju','data'=>$baju,'sizes'=>['All Size','S','M','L','XL','XXL','XXXL']],['key'=>'celana','title'=>'Stok Celana','data'=>$celana,'sizes'=>['All Size','S','M','L','XL','XXL','XXXL']]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="rounded-2xl border border-[#E7E0D6] bg-white p-6 shadow-sm">
                <h3 class="font-semibold text-[#2C2926]"><?php echo e($group['title']); ?></h3>
                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <?php $__currentLoopData = $group['sizes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><label class="text-sm font-medium text-[#5F5953]"><?php echo e($size); ?></label><input type="number" min="0" name="<?php echo e($group['key']); ?>[<?php echo e($size); ?>]" value="<?php echo e(old($group['key'].'.'.$size, $group['data']->get($size)?->quantity ?? 0)); ?>" class="mt-2 w-full rounded-xl border border-[#DCCFC3] px-4 py-3 text-sm"></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="flex justify-end gap-3"><a href="<?php echo e(route('admin.costumes.index')); ?>" class="rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-600">Batal</a><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#7B1E2B] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#641722] disabled:cursor-wait disabled:opacity-75" data-save-costume><span data-save-label>Simpan Perubahan</span></button></div>
    </form>

    
    <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($image['id']): ?>
            <form id="delete-costume-image-<?php echo e($image['id']); ?>"
                  action="<?php echo e(route('admin.costumes.images.destroy', [$costume, $image['id']])); ?>"
                  method="POST"
                  class="hidden">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
document.querySelector('[data-costume-edit-form]')?.addEventListener('submit', function () {
    const button = this.querySelector('[data-save-costume]');
    const label = this.querySelector('[data-save-label]');

    if (!button || !label) return;

    button.disabled = true;
    label.textContent = 'Menyimpan...';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/admin/costume/edit.blade.php ENDPATH**/ ?>