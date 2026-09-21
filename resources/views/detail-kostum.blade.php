@php
    /*
    |--------------------------------------------------------------------------
    | SEBAJAR.ID — Detail Kostum
    |--------------------------------------------------------------------------
    | Data berasal dari database.
    | Kompatibel dengan gambar lama pada costumes.image dan gallery
    | multi-image pada costume_images.
    */

    $adminWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $whatsappUrl = $adminWhatsapp ? 'https://wa.me/' . $adminWhatsapp . '?text=' . rawurlencode('Halo Admin Sebajar, saya ingin bertanya mengenai penyewaan kostum.') : '#';

    $galleryImages = collect();

    if (method_exists($costume, 'images')) {
        $galleryImages = $costume->images
            ->sortBy('sort_order')
            ->values();
    }

    $getImageUrl = function ($path) {
        if (!$path) {
            return null;
        }

        $path = ltrim((string) $path, '/');

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return str_starts_with($path, 'images/')
            ? asset($path)
            : asset('images/' . $path);
    };

    $galleryUrls = $galleryImages->map(function ($image) use ($getImageUrl) {
        return $image->image_url ?? $getImageUrl($image->image_path ?? null);
    })->filter()->values();

    $mainImage = $galleryUrls->first()
        ?: $costume->image_url
        ?: asset('images/sebajar-logo.png');

    if ($galleryUrls->isEmpty() && $costume->image_url) {
        $galleryUrls = collect([$costume->image_url]);
    }

    $shirtSizes = $costume->sizes
        ->where('category', 'baju')
        ->sortBy('id');

    $pantsSizes = $costume->sizes
        ->where('category', 'celana')
        ->sortBy('id');

    $shirtTotal = $shirtSizes->sum('quantity');
    $pantsTotal = $pantsSizes->sum('quantity');
    $stockSets = min($shirtTotal, $pantsTotal);

    $shirtColors = [];
    if (!empty($costume->shirt_colors)) {
        $shirtColors = is_array($costume->shirt_colors)
            ? $costume->shirt_colors
            : (json_decode($costume->shirt_colors, true) ?? []);
    }

    $status = $costume->status ?? ($costume->is_active ?? true ? 'Tersedia' : 'Tidak Tersedia');
    $description = $costume->description ?? null;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('images/sebajar-logo.png') }}">

    <title>{{ $costume->code }} — {{ $costume->name }} | Sebajar.id</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,500,0,0"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/sebajar-home.css') }}">

    <style>
        :root{
            --red:#cf202b;
            --dark:#111;
            --text:#272727;
            --muted:#77736f;
            --line:#e7e3df;
            --cream:#f8f6f3;
            --green:#2d7a4b;
            --green-bg:#edf8f0;
            --orange:#a25c17;
            --orange-bg:#fff5e8;
        }

        *{box-sizing:border-box}

        body{
            margin:0;
            color:var(--text);
            font-family:Inter,sans-serif;
            background:#fff
        }

        a{text-decoration:none;color:inherit}

        .nav{
            position:sticky;
            top:0;
            z-index:10;
            background:rgba(255,255,255,.96);
            border-bottom:1px solid var(--line);
            backdrop-filter:blur(10px)
        }

        .nav-in,.main,.footer-in,.footer-bottom{
            width:min(1180px,calc(100% - 40px));
            margin:auto
        }

        .nav-in{
            min-height:76px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:25px
        }

        .brand{
            display:flex;
            align-items:center;
            gap:10px
        }

        .brand-logo{
            width:145px;
            height:auto;
            display:block
        }

        .links{
            display:flex;
            gap:28px;
            font-size:13px;
            font-weight:600;
            color:#555
        }

        .links a:hover{color:var(--red)}

        .contact{
            padding:11px 17px;
            background:var(--dark);
            color:#fff;
            border-radius:8px;
            font-size:12px;
            font-weight:700
        }

        .main{
            padding:30px 0 80px
        }

        .crumb{
            display:flex;
            gap:7px;
            align-items:center;
            margin-bottom:28px;
            color:#888;
            font-size:11px
        }

        .crumb a:hover{color:var(--red)}

        .detail{
            display:grid;
            grid-template-columns:1.05fr .95fr;
            gap:58px
        }

        .gallery{
            position:sticky;
            top:105px
        }

        .hero-img{
            aspect-ratio:1/.9;
            overflow:hidden;
            border:1px solid var(--line);
            border-radius:14px;
            background:#eee
        }

        .hero-img img{
            width:100%;
            height:100%;
            object-fit:cover
        }

        .thumbs{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:10px;
            margin-top:10px
        }

        .thumb{
            padding:0;
            aspect-ratio:1/.85;
            overflow:hidden;
            border:1px solid var(--line);
            border-radius:8px;
            background:#fff;
            cursor:pointer
        }

        .thumb.active{border:2px solid var(--red)}

        .thumb img{
            width:100%;
            height:100%;
            object-fit:cover
        }

        .category{
            color:var(--red);
            font-size:10px;
            font-weight:800;
            letter-spacing:.13em;
            text-transform:uppercase;
            margin-bottom:10px
        }

        .title{
            margin:0 0 7px;
            color:var(--dark);
            font:800 clamp(29px,4vw,45px)/1.08 Montserrat;
            letter-spacing:-.04em
        }

        .code{
            margin-bottom:22px;
            color:#999;
            font-size:11px;
            font-weight:700
        }

        .status{
            display:inline-flex;
            gap:8px;
            align-items:center;
            margin-bottom:25px;
            padding:8px 11px;
            border-radius:6px;
            background:{{ $status==='Terbatas' ? 'var(--orange-bg)' : 'var(--green-bg)' }};
            color:{{ $status==='Terbatas' ? 'var(--orange)' : 'var(--green)' }};
            font-size:11px;
            font-weight:800
        }

        .dot{
            width:7px;
            height:7px;
            border-radius:50%;
            background:currentColor
        }

        .desc{
            margin:0 0 28px;
            color:var(--muted);
            font-size:13px;
            line-height:1.8
        }

        .block{
            padding:21px 0;
            border-top:1px solid var(--line)
        }

        .label{
            margin-bottom:12px;
            font-size:11px;
            font-weight:800
        }

        /* ========================= STOCK SUMMARY ========================= */

        .stock-summary{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:10px;
            margin-bottom:15px
        }

        .stock-card{
            padding:15px;
            border:1px solid var(--line);
            border-radius:9px;
            background:#fff
        }

        .stock-card-label{
            margin-bottom:5px;
            color:#8a847f;
            font-size:9px;
            font-weight:800;
            letter-spacing:.08em;
            text-transform:uppercase
        }

        .stock-card-value{
            color:var(--dark);
            font:800 20px Montserrat
        }

        .stock-card-note{
            margin-top:3px;
            color:#999;
            font-size:9px
        }

        .variant-label{
            margin:20px 0 9px;
            color:#55504c;
            font-size:10px;
            font-weight:800
        }

        .color-list{
            display:flex;
            flex-wrap:wrap;
            gap:8px
        }

        .color-item{
            display:inline-flex;
            align-items:center;
            gap:7px;
            min-height:36px;
            padding:0 11px;
            border:1px solid #d9d4d0;
            border-radius:7px;
            background:#fff;
            font-size:10px;
            font-weight:700
        }

        .color-dot{
            width:8px;
            height:8px;
            border-radius:50%;
            background:#aaa;
            border:1px solid rgba(0,0,0,.12)
        }

        .color-dot.ungu{background:#6f426e}
        .color-dot.peach{background:#e8ad91}
        .color-dot.merah{background:#b52d35}
        .color-dot.biru{background:#79a9c4}
        .color-dot.hijau{background:#3d7659}
        .color-dot.maroon{background:#6c2634}
        .color-dot.gold{background:#c5a34b}
        .color-dot.black{background:#171717}
        .color-dot.pink{background:#e78ca7}

        /* ========================= SIZE TABLE ========================= */

        .inventory-group{
            margin-top:15px
        }

        .inventory-title{
            margin-bottom:8px;
            color:#55504c;
            font-size:10px;
            font-weight:800
        }

        .inventory-table{
            overflow:hidden;
            border:1px solid var(--line);
            border-radius:8px
        }

        .inventory-row{
            display:grid;
            grid-template-columns:1fr 85px;
            min-height:39px;
            align-items:center;
            padding:0 12px;
            border-top:1px solid var(--line);
            font-size:10px
        }

        .inventory-row:first-child{
            border-top:0
        }

        .inventory-row.header{
            min-height:35px;
            color:#88817c;
            background:var(--cream);
            font-size:8px;
            font-weight:800;
            letter-spacing:.06em;
            text-transform:uppercase
        }

        .inventory-qty{
            text-align:right;
            font-weight:800
        }

        .inventory-total{
            color:var(--red)
        }

        .additional-stock{
            display:flex;
            align-items:flex-start;
            gap:8px;
            margin-top:10px;
            padding:10px 12px;
            border-radius:7px;
            color:#706a66;
            background:#f7f5f2;
            font-size:9px;
            line-height:1.55
        }

        .additional-stock .material-symbols-outlined{
            color:var(--red);
            font-size:16px
        }

        .rental{
            margin-top:8px;
            padding:22px;
            border:1px solid #ebe7e3;
            border-radius:12px;
            background:var(--cream)
        }

        .rental h2{
            margin:0 0 8px;
            font:700 16px Montserrat
        }

        .rental p{
            margin:0 0 17px;
            color:var(--muted);
            font-size:11px;
            line-height:1.65
        }

        .actions{
            display:flex;
            gap:9px
        }

        .btn{
            min-height:44px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            padding:0 16px;
            border-radius:7px;
            font-size:11px;
            font-weight:800
        }

        .primary{
            flex:1;
            background:var(--red);
            color:#fff
        }

        .secondary{
            background:#fff;
            border:1px solid #d9d4d0
        }

        .help{
            margin-top:75px;
            padding:32px 38px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:30px;
            background:var(--dark);
            color:#fff;
            border-radius:13px
        }

        .help h2{
            margin:0 0 7px;
            font:700 20px Montserrat
        }

        .help p{
            max-width:610px;
            margin:0;
            color:#aaa;
            font-size:11px;
            line-height:1.65
        }

        .help a{
            padding:12px 18px;
            background:var(--red);
            border-radius:7px;
            font-size:11px;
            font-weight:800
        }

        .footer{
            padding:56px 0 30px;
            background:#111;
            color:#fff
        }

        .footer-in{
            display:grid;
            grid-template-columns:1.4fr 1fr 1fr;
            gap:60px
        }

        .footer-logo{
            width:145px;
            height:auto;
            display:block;
            filter:brightness(0) invert(1);
            margin-bottom:14px
        }

        .footer p{
            max-width:330px;
            color:#999;
            font-size:12px;
            line-height:1.7
        }

        .footer h3{
            margin:0 0 15px;
            font-size:11px;
            letter-spacing:.08em;
            text-transform:uppercase
        }

        .footer-links{
            display:flex;
            flex-direction:column;
            gap:10px
        }

        .footer-links a{
            color:#999;
            font-size:12px
        }

        .footer-links a:hover{color:#ef4b54}

        .footer-bottom{
            margin-top:40px;
            padding-top:22px;
            border-top:1px solid #272727;
            color:#666;
            font-size:10px
        }

        @media(max-width:900px){
            .links{display:none}
            .detail{
                grid-template-columns:1fr;
                gap:38px
            }
            .gallery{position:static}
            .footer-in{
                grid-template-columns:1fr 1fr;
                gap:35px
            }
        }

        @media(max-width:600px){
            .nav-in,.main,.footer-in,.footer-bottom{
                width:calc(100% - 28px)
            }

            .contact{display:none}

            .detail{gap:28px}

            .stock-summary{
                grid-template-columns:1fr
            }

            .actions{
                flex-direction:column
            }

            .help{
                align-items:flex-start;
                flex-direction:column;
                padding:25px 21px
            }

            .help a{
                width:100%;
                text-align:center
            }

            .footer-in{
                grid-template-columns:1fr
            }
        }
    </style>
</head>

<body>

@include('partials.user-header')

<main class="main">

    <div class="crumb">
        <a href="{{ url('/') }}">Beranda</a>
        <span>›</span>
        <a href="{{ url('/koleksi') }}">Koleksi</a>
        <span>›</span>
        <span>{{ $costume->code }}</span>
    </div>

    <section class="detail">

        {{-- ========================= GALLERY ========================= --}}
        <div class="gallery">

            <div class="hero-img">
                <img
                    id="mainImage"
                    src="{{ $mainImage }}"
                    alt="{{ $costume->code }} {{ $costume->name }}"
                >
            </div>

            <div class="thumbs">
                @foreach($galleryUrls as $index => $imageUrl)
                    <button
                        class="thumb {{ $index === 0 ? 'active' : '' }}"
                        data-image="{{ $imageUrl }}"
                        type="button"
                    >
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $costume->name }} - gambar {{ $index + 1 }}"
                        >
                    </button>
                @endforeach
            </div>

        </div>

        {{-- ========================= DETAIL ========================= --}}
        <div>

            <div class="category">Kostum Saman</div>

            <h1 class="title">{{ $costume->name }}</h1>

            <div class="code">
                Kode Kostum: {{ $costume->code }}
            </div>

            <div class="status">
                <span class="dot"></span>
                {{ $status }}
            </div>

            <p class="desc">
                @if($description)
                    {{ $description }}
                @else
                    Kostum Tari Saman dengan kombinasi warna
                    <strong>{{ $costume->name }}</strong>,
                    cocok digunakan untuk pertunjukan, lomba, acara sekolah,
                    komunitas, dan kegiatan seni.
                @endif
            </p>

            {{-- ========================= STOCK SUMMARY ========================= --}}
            <div class="block">

                <div class="label">Ketersediaan Kostum</div>

                <div class="stock-summary">

                    <div class="stock-card">
                        <div class="stock-card-label">Set Utama</div>
                        <div class="stock-card-value">{{ $stockSets }} Set</div>
                        <div class="stock-card-note">
                            1 set = 1 baju + 1 celana
                        </div>
                    </div>

                    <div class="stock-card">
                        <div class="stock-card-label">Baju</div>
                        <div class="stock-card-value">{{ $shirtTotal }} Pcs</div>
                        <div class="stock-card-note">
                            Stok baju dalam 20 set
                        </div>
                    </div>

                </div>

                <div class="variant-label">Warna Baju</div>

                <div class="color-list">
                    @foreach($shirtColors as $color)
                        @php
                            $colorClass = strtolower($color);

                            if (str_contains($colorClass, 'ungu')) {
                                $colorClass = 'ungu';
                            } elseif (str_contains($colorClass, 'peach')) {
                                $colorClass = 'peach';
                            } elseif (str_contains($colorClass, 'merah')) {
                                $colorClass = 'merah';
                            } elseif (str_contains($colorClass, 'biru')) {
                                $colorClass = 'biru';
                            } elseif (str_contains($colorClass, 'hijau')) {
                                $colorClass = 'hijau';
                            } elseif (str_contains($colorClass, 'maroon')) {
                                $colorClass = 'maroon';
                            } elseif (str_contains($colorClass, 'gold')) {
                                $colorClass = 'gold';
                            } elseif (str_contains($colorClass, 'black')) {
                                $colorClass = 'black';
                            } elseif (str_contains($colorClass, 'pink')) {
                                $colorClass = 'pink';
                            }
                        @endphp

                        <span class="color-item">
                            <span class="color-dot {{ $colorClass }}"></span>
                            {{ $color }}
                        </span>
                    @endforeach
                </div>

            </div>

            {{-- ========================= SHIRT SIZE ========================= --}}
            <div class="block">

                <div class="label">Ukuran & Jumlah Baju</div>

                <div class="inventory-table">

                    <div class="inventory-row header">
                        <span>Ukuran</span>
                        <span style="text-align:right;">Stok</span>
                    </div>

                    @foreach($shirtSizes->where('quantity', '>', 0) as $stock)
                        <div class="inventory-row">
                            <span>{{ $stock->size }}</span>
                            <span class="inventory-qty">
                                {{ $stock->quantity }} pcs
                            </span>
                        </div>
                    @endforeach

                    <div class="inventory-row">

                        <span><strong>Total Baju</strong></span>

                        <span class="inventory-qty inventory-total">
                            {{ $shirtTotal }} pcs
                        </span>

                    </div>

                </div>

            </div>

            {{-- ========================= PANTS SIZE ========================= --}}
            <div class="block">

                <div class="label">Ukuran & Jumlah Celana</div>

                <div class="inventory-table">

                    <div class="inventory-row header">
                        <span>Ukuran</span>
                        <span style="text-align:right;">Stok</span>
                    </div>

                    @foreach($pantsSizes->where('quantity', '>', 0) as $stock)
                        <div class="inventory-row">
                            <span>{{ $stock->size }}</span>
                            <span class="inventory-qty">
                                {{ $stock->quantity }} pcs
                            </span>
                        </div>
                    @endforeach

                    <div class="inventory-row">

                        <span><strong>Total Celana</strong></span>

                        <span class="inventory-qty inventory-total">
                            {{ $pantsTotal }} pcs
                        </span>

                    </div>

                </div>

                <div class="additional-stock">

                    <span class="material-symbols-outlined">info</span>

                    <span>
                        Tersedia tambahan <strong>5 pcs celana XXXL</strong>
                        untuk seluruh koleksi Sebajar. Stok ini berada di luar
                        20 set utama dan tidak dihitung sebagai set tambahan.
                    </span>

                </div>

            </div>

            {{-- ========================= INFORMATION ========================= --}}
            <div class="block">

                <div class="label">Informasi Kostum</div>

                <div style="display:grid;gap:11px;color:#69645f;font-size:11px">

                    <div>
                        ✓ 1 set terdiri dari 1 baju dan 1 celana
                    </div>

                    <div>
                        ✓ Stok utama tersedia dalam 20 set
                    </div>

                    <div>
                        ✓ Ukuran baju dan celana memiliki komposisi berbeda
                    </div>

                    <div>
                        ✓ Ketersediaan akan disesuaikan dengan periode penyewaan
                    </div>

                    <div>
                        ✓ Pengajuan penyewaan akan dikonfirmasi oleh admin
                    </div>

                </div>

            </div>

            {{-- ========================= RENTAL CTA ========================= --}}
            <div class="rental">

                <h2>Ingin menggunakan kostum ini?</h2>

                <p>
                    Ajukan penyewaan dengan menentukan jumlah set, kebutuhan
                    ukuran baju dan celana, serta tanggal penggunaan.
                    Tim Sebajar.id akan memeriksa ketersediaan sebelum
                    pengajuan dikonfirmasi.
                </p>

                <div class="actions">

                    <a
                        class="btn primary"
                        href="{{ url('/penyewaan?kostum='.rawurlencode($costume->code)) }}"
                    >
                        Ajukan Penyewaan →
                    </a>

                    <a
                        class="btn secondary"
                        href="{{ $whatsappUrl }}"
                    >
                        Tanya Admin
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- ========================= HELP ========================= --}}
    <section class="help">

        <div>
            <h2>Butuh bantuan memilih kostum?</h2>

            <p>
                Jika belum yakin dengan warna, ukuran, jumlah set,
                atau kebutuhan celana XXXL, hubungi tim Sebajar.id.
            </p>
        </div>

        <a href="{{ $whatsappUrl }}">
            Hubungi Admin
        </a>

    </section>

</main>

<footer class="footer">

    <div class="footer-in">

        <div>

            <img
                src="{{ asset('images/sebajar-logo.png') }}"
                alt="Sebajar.id"
                class="footer-logo"
            >

            <p>
                Platform penyewaan kostum Tari Saman untuk kebutuhan
                pertunjukan, lomba, sekolah, komunitas, dan kegiatan seni.
            </p>

        </div>

        <div>

            <h3>Navigasi</h3>

            <div class="footer-links">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/koleksi') }}">Koleksi</a>
                <a href="{{ url('/#cara-sewa') }}">Cara Sewa</a>
                <a href="{{ url('/#tentang') }}">Tentang Kami</a>
            </div>

        </div>

        <div>

            <h3>Bantuan</h3>

            <div class="footer-links">
                <a href="{{ $whatsappUrl }}">Hubungi Admin</a>
                <a href="{{ url('/#cara-sewa') }}">Panduan Penyewaan</a>
                <a href="{{ url('/login') }}">Masuk</a>
                <a href="{{ url('/register') }}">Daftar</a>
            </div>

        </div>

    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} Sebajar.id. Seluruh hak cipta dilindungi.
    </div>

</footer>

<script>
    document.querySelectorAll('.thumb').forEach(function (thumbnail) {
        thumbnail.addEventListener('click', function () {

            const mainImage = document.getElementById('mainImage');

            mainImage.src = this.dataset.image;

            document
                .querySelectorAll('.thumb')
                .forEach(function (item) {
                    item.classList.remove('active');
                });

            this.classList.add('active');
        });
    });
</script>

</body>
</html>
