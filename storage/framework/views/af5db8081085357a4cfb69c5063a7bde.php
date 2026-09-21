<?php
    $footerWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $footerWhatsappUrl = $footerWhatsapp ? 'https://wa.me/' . $footerWhatsapp : '#';
?>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand-column">
            <img class="footer-logo" src="<?php echo e(asset('images/sebajar-logo.png')); ?>" alt="Sebajar.id">
            <p>Platform penyewaan kostum Tari Saman.</p>
        </div>
        <div class="footer-links">
            <div>
                <strong>Navigasi</strong>
                <a href="<?php echo e(url('/koleksi')); ?>">Koleksi Kostum</a>
                <a href="<?php echo e(url('/#cara-sewa')); ?>">Cara Sewa</a>
                <a href="<?php echo e(url('/#tentang')); ?>">Tentang Sebajar</a>
            </div>
            <div>
                <strong>Bantuan</strong>
                <a href="<?php echo e(url('/login')); ?>">Masuk</a>
                <a href="<?php echo e(url('/register')); ?>">Daftar</a>
                <a href="<?php echo e($footerWhatsappUrl); ?>" target="_blank" rel="noopener">Chat Admin</a>
            </div>
        </div>
    </div>
    <div class="container footer-bottom"><small>&copy; <?php echo e(date('Y')); ?> Sebajar.id. Semua hak dilindungi.</small></div>
</footer>
<?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/partials/public-footer.blade.php ENDPATH**/ ?>