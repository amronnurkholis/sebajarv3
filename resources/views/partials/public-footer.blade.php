@php
    $footerWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $footerWhatsappUrl = $footerWhatsapp ? 'https://wa.me/' . $footerWhatsapp : '#';
@endphp

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand-column">
            <img class="footer-logo" src="{{ asset('images/sebajar-logo.png') }}" alt="Sebajar.id">
            <p>Platform penyewaan kostum Tari Saman.</p>
        </div>
        <div class="footer-links">
            <div>
                <strong>Navigasi</strong>
                <a href="{{ url('/koleksi') }}">Koleksi Kostum</a>
                <a href="{{ url('/#cara-sewa') }}">Cara Sewa</a>
                <a href="{{ url('/#tentang') }}">Tentang Sebajar</a>
            </div>
            <div>
                <strong>Bantuan</strong>
                <a href="{{ url('/login') }}">Masuk</a>
                <a href="{{ url('/register') }}">Daftar</a>
                <a href="{{ $footerWhatsappUrl }}" target="_blank" rel="noopener">Chat Admin</a>
            </div>
        </div>
    </div>
    <div class="container footer-bottom"><small>&copy; {{ date('Y') }} Sebajar.id. Semua hak dilindungi.</small></div>
</footer>
