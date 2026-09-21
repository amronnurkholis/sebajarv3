@php
    /*
    |--------------------------------------------------------------------------
    | Sebajar.id Homepage
    |--------------------------------------------------------------------------
    | Temporary presentation data.
    | Later, replace these arrays with data from Costume/Team models.
    */

    $costumes = $costumes ?? [
        ['code' => 'SBJ 001', 'name' => 'Ungu - Peach', 'image' => 'images/costumes/sbj-001.jpg'],
        ['code' => 'SBJ 002', 'name' => 'Merah Manggis - Biru Langit', 'image' => 'images/costumes/sbj-002.jpg'],
        ['code' => 'SBJ 005', 'name' => 'Merah Cabai - Hijau Botol', 'image' => 'images/costumes/sbj-005.jpg'],
        ['code' => 'SBJ 006', 'name' => 'Maroon - Gold', 'image' => 'images/costumes/sbj-006.jpg'],
        ['code' => 'SBJ 014', 'name' => 'Black - Pink', 'image' => 'images/costumes/sbj-014.jpg'],
        ['code' => 'SBJ 017', 'name' => 'Pink - Biru', 'image' => 'images/costumes/sbj-017.jpg'],
    ];

    $teams = $teams ?? [
        ['image' => 'images/teams/team-01.jpg'],
        ['image' => 'images/teams/team-02.jpg'],
        ['image' => 'images/teams/team-03.jpg'],
        ['image' => 'images/teams/team-04.jpg'],
        ['image' => 'images/teams/team-05.jpg'],
    ];

    $adminWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $whatsappUrl = $adminWhatsapp ? 'https://wa.me/' . $adminWhatsapp . '?text=' . rawurlencode('Halo Admin Sebajar, saya ingin bertanya mengenai penyewaan kostum.') : '#';

    $getCostumeValue = function ($costume, string $key, $default = null) {
        return is_array($costume) ? ($costume[$key] ?? $default) : ($costume->{$key} ?? $default);
    };

    $getCostumeImage = function ($costume) use ($getCostumeValue) {
        if (is_array($costume)) {
            return asset($costume['image'] ?? 'images/sebajar-logo.png');
        }

        $imageUrl = $costume->image_url;

        if (! $imageUrl && $costume->relationLoaded('images')) {
            $imageUrl = $costume->images->first()?->image_url;
        }

        return $imageUrl ?: asset('images/sebajar-logo.png');
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sebajar.id — Sewa Kostum Tari Saman</title>
    <meta name="description" content="Sebajar.id menyediakan penyewaan kostum Tari Saman dengan berbagai pilihan warna, ukuran, dan jumlah untuk kebutuhan pertunjukan.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,500,0,0" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/sebajar-home.css') }}">
    <link
            rel="icon"
            type="image/png"
            href="{{ asset('images/sebajar-logo.png') }}"
        >

        <link
            rel="shortcut icon"
            type="image/png"
            href="{{ asset('images/sebajar-logo.png') }}"
        >
    <style>
        .order-cart-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .order-cart-link .material-symbols-outlined {
            font-size: 18px;
        }

        .order-cart-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #7B1E2B;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
        }

        /* Homepage-only adjustments requested for the Sebajar landing page. */
        .section-heading-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-carousel {
            position: relative;
        }

        .costume-grid-compact {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            padding: 2px 2px 10px;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
        }

        .costume-grid-compact::-webkit-scrollbar {
            display: none;
        }

        .costume-grid-compact .costume-card {
            flex: 0 0 calc((100% - 72px) / 4);
            scroll-snap-align: start;
        }

        .costume-card-compact .costume-body {
            padding: 15px 2px 4px;
        }

        .costume-card-compact .costume-body h3 {
            font-size: 15px;
            margin-bottom: 10px;
        }

        .costume-card-compact .costume-image {
            aspect-ratio: 4 / 3;
        }

        .costume-card-compact .card-link {
            font-size: 12px;
            padding-top: 2px;
        }

        .product-carousel-control {
            width: 38px;
            height: 38px;
            display: inline-grid;
            place-items: center;
            padding: 0;
            border: 1px solid #d8d2ce;
            border-radius: 50%;
            color: #37302b;
            background: #fff;
            cursor: pointer;
            transition: color .16s ease, border-color .16s ease, background .16s ease, transform .16s ease;
        }

        .product-carousel-control:hover {
            color: #7b1e2b;
            border-color: #7b1e2b;
            transform: translateY(-1px);
        }

        .product-carousel-control:focus-visible {
            outline: 3px solid rgba(123, 30, 43, .3);
            outline-offset: 3px;
        }

        .product-carousel-control .material-symbols-outlined {
            font-size: 20px;
        }

        .collection-cta {
            min-height: 42px;
            padding: 9px 17px;
            color: #37302b;
            background: transparent;
            border-color: #cfc7c0;
        }

        .collection-cta:hover {
            color: #7b1e2b;
            background: #fff;
            border-color: #7b1e2b;
        }

        @media (max-width: 1050px) {
            .costume-grid-compact .costume-card { flex-basis: calc((100% - 48px) / 3); }
        }

        @media (max-width: 720px) {
            .costume-grid-compact { gap: 16px; }
            .costume-grid-compact .costume-card { flex-basis: calc((100% - 16px) / 2); }
        }

        @media (max-width: 560px) {
            .section-heading-actions { width: 100%; justify-content: space-between; }
            .costume-grid-compact .costume-card { flex-basis: 82%; }
            .product-carousel-control { width: 36px; height: 36px; }
        }

        .team-grid-large {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
        }

        .team-card-large {
            min-height: 230px;
            padding: 12px;
            background: #fff;
        }

        .team-logo-large {
            width: 100%;
            height: 100%;
            min-height: 200px;
        }

        .team-logo-large img {
            width: 100%;
            height: 100%;
            max-width: none;
            max-height: none;
            object-fit: cover;
            border-radius: 9px;
        }

        @media (max-width: 1100px) {
            .costume-grid-compact {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .team-grid-large {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 800px) {
            .costume-grid-compact,
            .team-grid-large {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .team-card-large {
                min-height: 190px;
            }

            .team-logo-large {
                min-height: 160px;
            }
        }

        @media (max-width: 560px) {
            .costume-grid-compact,
            .team-grid-large {
                grid-template-columns: 1fr;
            }

            .team-card-large {
                min-height: 240px;
            }

            .team-logo-large {
                min-height: 215px;
            }
        }
    </style>
</head>

<body>
    @include('partials.user-header')

    <main>
        {{-- HERO --}}
        <section class="hero" id="beranda">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                <div class="hero-copy reveal">
                    
                    <h1>Temukan Kostum <span>Tari Saman</span> yang Kamu Butuhkan</h1>
                    <p>
                        Sewa kostum Tari Saman dengan pilihan warna dan ukuran
                        untuk kebutuhan penampilan, latihan, perlombaan, maupun acara budaya.
                    </p>

                    <div class="hero-actions">
                        <a href="#koleksi" class="btn hero-collection-cta">Lihat Koleksi <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
                        <a href="#cara-sewa" class="hero-how-cta">Cara Sewa <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
                    </div>
                </div>
            </div>

            @if (!empty($rentalStatus['next_change']))
                <aside class="hero-rental-status {{ $rentalStatus['is_open'] ? 'is-open' : 'is-closed' }}" data-rental-status data-next-change="{{ $rentalStatus['next_change'] }}" aria-live="polite">
                    <span class="material-symbols-outlined" aria-hidden="true">{{ $rentalStatus['is_open'] ? 'schedule' : 'lock_clock' }}</span>
                    <span class="hero-rental-copy">
                        <strong>Penyewaan sedang {{ $rentalStatus['is_open'] ? 'dibuka' : 'ditutup' }}</strong>
                    </span>
                    <strong class="hero-rental-time" data-countdown>--:--:--</strong>
                    <span class="hero-rental-caption">{{ $rentalStatus['is_open'] ? 'Sisa waktu' : 'Dibuka kembali' }}</span>
                </aside>
            @endif
        </section>

        {{-- TENTANG --}}
        <section class="section section-white" id="tentang">
            <div class="container intro-grid">
                <div class="intro-copy reveal">
                    <span class="eyebrow">SEBAJAR.ID</span>
                    <h2>Kostum Tari Saman untuk Kebutuhan Penampilanmu</h2>
                    <p>
                        Sebajar.id hadir sebagai platform penyewaan kostum Tari Saman
                        untuk membantu tim tari, sanggar, sekolah, komunitas, dan kebutuhan
                        pertunjukan mendapatkan kostum yang sesuai.
                    </p>
                    <p>
                        Kamu dapat melihat koleksi, memahami pilihan ukuran dan jumlah,
                        menentukan tanggal sewa, lalu mengajukan penyewaan kepada admin.
                    </p>

                    <div class="stats-row">
                        <div class="stat-item">
                            <strong>Beragam</strong>
                            <span>Warna &amp; varian kostum</span>
                        </div>
                        <div class="stat-item">
                            <strong>Terstruktur</strong>
                            <span>Ukuran &amp; jumlah jelas</span>
                        </div>
                        <div class="stat-item">
                            <strong>Terarah</strong>
                            <span>Dibantu admin Sebajar</span>
                        </div>
                    </div>
                </div>

                <div class="intro-image reveal">
                    <img src="{{ asset('images/hero/tari-saman-2.jpg') }}"
                         alt="Penari Tari Saman mengenakan kostum">
                </div>
            </div>
        </section>

        {{-- KOLEKSI --}}
        <section class="section section-ivory" id="koleksi">
            <div class="container">
                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">KOLEKSI KOSTUM KAMI</span>
                        <h2>Koleksi Kostum Tari Saman</h2>
                        <p>Pilih kostum sesuai kebutuhan penampilanmu.</p>
                    </div>
                    <div class="section-heading-actions">
                        <a href="{{ url('/koleksi') }}" class="text-link">
                            Lihat Semua
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <button type="button" class="product-carousel-control" data-product-carousel-prev aria-label="Kostum sebelumnya">
                            <span class="material-symbols-outlined" aria-hidden="true">chevron_left</span>
                        </button>
                        <button type="button" class="product-carousel-control" data-product-carousel-next aria-label="Kostum berikutnya">
                            <span class="material-symbols-outlined" aria-hidden="true">chevron_right</span>
                        </button>
                    </div>
                </div>

                <div class="product-carousel">
                <div class="costume-grid costume-grid-compact" data-product-carousel aria-label="Koleksi kostum unggulan">
                    @foreach ($costumes as $costume)
                        @php
                            $costumeCode = $getCostumeValue($costume, 'code', '-');
                            $costumeName = $getCostumeValue($costume, 'name', 'Kostum Tari Saman');
                            $costumeImage = $getCostumeImage($costume);
                            $costumeDetailUrl = $costumeCode !== '-' ? url('/koleksi/' . rawurlencode($costumeCode)) : url('/koleksi');
                        @endphp
                        <article class="costume-card costume-card-compact reveal">
                            <div class="costume-image">
                                <img src="{{ $costumeImage }}"
                                     alt="{{ $costumeCode }} — {{ $costumeName }}"
                                     loading="lazy">
                                <div class="availability">
                                    <span class="availability-dot"></span>
                                    Tersedia
                                </div>
                                <a href="{{ $costumeDetailUrl }}" class="costume-image-detail" aria-label="Lihat detail {{ $costumeName }}">
                                    <span class="material-symbols-outlined" aria-hidden="true">visibility</span>
                                    <span>Lihat Detail</span>
                                </a>
                            </div>

                            <div class="costume-body">
                                <span class="costume-code">{{ $costumeCode }}</span>
                                <h3>{{ $costumeName }}</h3>

                                <a href="{{ $costumeDetailUrl }}" class="card-link">
                                    Lihat Detail
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                </div>

                <div class="center-action">
                    <a href="{{ url('/koleksi') }}" class="btn btn-outline collection-cta">Lihat Semua Koleksi <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
                </div>
            </div>
        </section>

        {{-- BENEFITS --}}
        <section class="section section-white">
            <div class="container">
                <div class="center-heading reveal">
                    <span class="eyebrow">KENAPA SEWA DI SEBAJAR?</span>
                    <h2>Keuntungan Menyewa di Sebajar.id</h2>
                </div>

                <div class="benefit-grid">
                    <article class="benefit-card reveal">
                        <div class="icon-circle">
                            <span class="material-symbols-outlined">checkroom</span>
                        </div>
                        <h3>Kostum Berkualitas</h3>
                        <p>Kostum dirawat dan dipersiapkan untuk kebutuhan penampilan Tari Saman.</p>
                    </article>

                    <article class="benefit-card reveal">
                        <div class="icon-circle">
                            <span class="material-symbols-outlined">palette</span>
                        </div>
                        <h3>Variasi Warna</h3>
                        <p>Pilihan kombinasi warna membantu menyesuaikan kebutuhan tim dan acara.</p>
                    </article>

                    <article class="benefit-card reveal">
                        <div class="icon-circle">
                            <span class="material-symbols-outlined">event</span>
                        </div>
                        <h3>Proses Sewa Jelas</h3>
                        <p>Tentukan kostum, ukuran, jumlah, tanggal sewa, lalu ajukan kepada admin.</p>
                    </article>

                    <article class="benefit-card reveal">
                        <div class="icon-circle">
                            <span class="material-symbols-outlined">support_agent</span>
                        </div>
                        <h3>Dibantu Admin</h3>
                        <p>Admin siap membantu jika kamu membutuhkan informasi sebelum menyewa.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- TIM YANG PERNAH MENGGUNAKAN --}}
        <section class="section section-ivory" id="tim">
            <div class="container">
                <div class="center-heading reveal">
                    <span class="eyebrow">TIM YANG PERNAH MENGGUNAKAN KOSTUM KAMI</span>
                    <h2>Dipercaya oleh Berbagai Tim</h2>
                    <p>
                        Kostum Sebajar telah digunakan untuk berbagai kebutuhan penampilan
                        oleh sekolah, sanggar, komunitas, dan institusi.
                    </p>
                </div>

                <div class="team-grid team-grid-large">
                    @foreach ($teams as $team)
                        <div class="team-card team-card-large reveal">
                            <div class="team-logo team-logo-large">
                                <img src="{{ asset($team['image']) }}"
                                     alt="Tim yang pernah menggunakan kostum Sebajar.id"
                                     loading="lazy">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="testimonial reveal">
                    <span class="quote-mark">“</span>
                    <p>
                        Kostumnya bagus, rapi, dan nyaman dipakai. Adminnya juga sangat responsif.
                    </p>
                    <strong>— Tim / Sanggar Sebajar</strong>
                </div>
            </div>
        </section>

        {{-- CARA SEWA --}}
        <section class="section section-white" id="cara-sewa">
            <div class="container how-to-wrap">
                <div class="how-to-copy reveal">
                    <span class="eyebrow">CARA MENYEWA KOSTUM</span>
                    <h2>Mudah dalam 6 Langkah</h2>
                    <p>
                        Tidak perlu bingung. Ikuti alur berikut untuk mengajukan penyewaan
                        kostum Tari Saman di Sebajar.id.
                    </p>

                    <a href="{{ url('/koleksi') }}" class="btn btn-primary">
                        Mulai Pilih Kostum
                    </a>
                </div>

                <div class="steps">
                    <article class="step reveal">
                        <span class="step-number">01</span>
                        <div>
                            <h3>Pilih Kostum</h3>
                            <p>Pilih koleksi dan kombinasi warna yang sesuai kebutuhan timmu.</p>
                        </div>
                    </article>

                    <article class="step reveal">
                        <span class="step-number">02</span>
                        <div>
                            <h3>Pilih Ukuran &amp; Jumlah</h3>
                            <p>Tentukan ukuran dan jumlah set kostum yang dibutuhkan.</p>
                        </div>
                    </article>

                    <article class="step reveal">
                        <span class="step-number">03</span>
                        <div>
                            <h3>Tentukan Tanggal Sewa</h3>
                            <p>Masukkan tanggal mulai sewa dan tanggal kembali kostum.</p>
                        </div>
                    </article>

                    <article class="step reveal">
                        <span class="step-number">04</span>
                        <div>
                            <h3>Masuk atau Daftar</h3>
                            <p>Login atau buat akun untuk melanjutkan pengajuan penyewaan.</p>
                        </div>
                    </article>

                    <article class="step reveal">
                        <span class="step-number">05</span>
                        <div>
                            <h3>Ajukan Sewa</h3>
                            <p>Periksa ringkasan penyewaan lalu kirim permintaan kepada admin.</p>
                        </div>
                    </article>

                    <article class="step reveal">
                        <span class="step-number">06</span>
                        <div>
                            <h3>Konfirmasi &amp; Ambil Kostum</h3>
                            <p>Admin memproses permintaan dan membantu proses pengambilan/pengembalian.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- CTA ADMIN --}}
        <section class="section section-ivory">
            <div class="container">
                <div class="support-card reveal">
                    <div>
                        <span class="eyebrow">BUTUH BANTUAN?</span>
                        <h2>Masih Bingung Memilih Kostum?</h2>
                        <p>
                            Chat dengan admin Sebajar untuk membantu memilih kostum,
                            ukuran, jumlah, atau kebutuhan penyewaanmu.
                        </p>
                    </div>

                    <a href="{{ $whatsappUrl }}" class="btn btn-primary" target="_blank" rel="noopener">
                        <span class="material-symbols-outlined">chat</span>
                        Chat Admin
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-brand-column">
                <img class="footer-logo" src="{{ asset('images/sebajar-logo.png') }}" alt="Sebajar.id">
                <p>Platform penyewaan kostum Tari Saman.</p>
            </div>

            <div class="footer-links">
                <div>
                    <strong>Navigasi</strong>
                    <a href="#koleksi">Koleksi Kostum</a>
                    <a href="#cara-sewa">Cara Sewa</a>
                    <a href="#tentang">Tentang Sebajar</a>
                </div>

                <div>
                    <strong>Bantuan</strong>
                    <a href="{{ url('/login') }}">Masuk</a>
                    <a href="{{ url('/login') }}">Daftar</a>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener">Chat Admin</a>
                </div>
            </div>
        </div>
        <div class="container footer-bottom">
            <small>&copy; {{ date('Y') }} Sebajar.id. Semua hak dilindungi.</small>
        </div>
    </footer>

    <script src="{{ asset('js/sebajar-home.js') }}"></script>
</body>
</html>
