<?php
    /*
    |--------------------------------------------------------------------------
    | Sebajar.id — Halaman Koleksi
    |--------------------------------------------------------------------------
    | Data koleksi sekarang diambil dari database melalui controller.
    | 1 set = 1 baju + 1 celana.
    */

    $adminWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $whatsappUrl = $adminWhatsapp ? 'https://wa.me/' . $adminWhatsapp . '?text=' . rawurlencode('Halo Admin Sebajar, saya ingin bertanya mengenai penyewaan kostum.') : '#';

    /*
    |--------------------------------------------------------------------------
    | Helper gambar
    |--------------------------------------------------------------------------
    | Mendukung:
    | - gambar lama/seeder: images/...
    | - gambar upload admin: costumes/...
    */
    $getImageUrl = function ($costume) {
        if (is_array($costume)) {
            $image = $costume['image'] ?? null;

            return $image ? asset($image) : null;
        }

        $imageUrl = $costume->image_url;

        if (! $imageUrl && $costume->relationLoaded('images')) {
            $imageUrl = $costume->images->first()?->image_url;
        }

        return $imageUrl;
    };

    /*
    |--------------------------------------------------------------------------
    | Helper data kostum
    |--------------------------------------------------------------------------
    */
    $getValue = function ($costume, string $key, $default = null) {
        return is_array($costume)
            ? ($costume[$key] ?? $default)
            : ($costume->{$key} ?? $default);
    };

    /*
    |--------------------------------------------------------------------------
    | Availability
    |--------------------------------------------------------------------------
    | Stok dihitung oleh CollectionController melalui
    | RentalAvailabilityService. Blade hanya menampilkan hasilnya.
    */
    $rentalDate = $rentalDate ?? request('rental_date');
    $stock = $stock ?? [];

    $getAvailability = function ($costume) use ($stock, $getValue) {
        $code = (string) $getValue($costume, 'code', '');

        return $stock[$code] ?? [
            'total' => 0,
            'reserved' => 0,
            'available' => 0,
            'sizes' => [
                'baju' => [],
                'celana' => [],
            ],
        ];
    };
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Koleksi Kostum — Sebajar.id</title>

    <meta
        name="description"
        content="Jelajahi koleksi kostum Tari Saman Sebajar.id untuk kebutuhan pertunjukan, lomba, acara sekolah, komunitas, dan kegiatan seni."
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,500,0,0"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="<?php echo e(asset('css/sebajar-home.css')); ?>">

    <link
        rel="icon"
        type="image/png"
        href="<?php echo e(asset('images/sebajar-logo.png')); ?>"
    >

    <link
        rel="shortcut icon"
        type="image/png"
        href="<?php echo e(asset('images/sebajar-logo.png')); ?>"
    >

    <style>
        :root {
            --red: #cf202b;
            --red-dark: #aa1721;
            --black: #111111;
            --text: #272727;
            --muted: #77736f;
            --line: #e7e3df;
            --cream: #f8f6f3;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            background: var(--white);
            font-family: 'Inter', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select {
            font: inherit;
        }

        .collection-page {
            min-height: 100vh;
            background: #fff;
        }

        /* =========================
           NAVBAR
           ========================= */

        .collection-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .collection-nav-inner {
            width: min(1180px, calc(100% - 40px));
            min-height: 76px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .brand img {
            width: 145px;
            height: auto;
            display: block;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            color: #55514e;
            font-size: 13px;
            font-weight: 600;
        }

        .nav-links a {
            position: relative;
            padding: 29px 0;
        }

        .nav-links a.active,
        .nav-links a:hover {
            color: var(--red);
        }

        .nav-links a.active::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 20px;
            height: 2px;
            background: var(--red);
        }

        .nav-action {
            padding: 11px 17px;
            color: #fff;
            background: var(--black);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        /* =========================
           HERO
           ========================= */

        .collection-hero {
            background: var(--cream);
            border-bottom: 1px solid var(--line);
        }

        .collection-hero-inner {
            width: min(1180px, calc(100% - 40px));
            margin: auto;
            padding: 70px 0 64px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 17px;
            color: var(--red);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 26px;
            height: 2px;
            background: var(--red);
        }

        .collection-hero h1 {
            max-width: 720px;
            margin: 0 0 16px;
            font-family: 'Montserrat', sans-serif;
            color: var(--black);
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.04;
            letter-spacing: -.045em;
        }

        .collection-hero h1 span {
            color: var(--red);
        }

        .collection-hero p {
            max-width: 650px;
            margin: 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.75;
        }

        /* =========================
           TANGGAL SEWA
           ========================= */

        .rental-date-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
            padding: 18px 20px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--cream);
        }

        .rental-date-copy {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .rental-date-copy > .material-symbols-outlined {
            flex: 0 0 auto;
            color: var(--red);
            font-size: 25px;
        }

        .rental-date-copy h2 {
            margin: 0 0 4px;
            color: var(--black);
            font-family: Montserrat, sans-serif;
            font-size: 15px;
        }

        .rental-date-copy p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .rental-date-control {
            width: min(360px, 100%);
            flex: 0 0 auto;
        }

        .rental-date-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-apply-button {
            min-height: 42px;
            padding: 0 17px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: var(--red);
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: .18s ease;
        }

        .date-apply-button:hover { background: var(--red-dark); transform: translateY(-1px); }
        .date-apply-button:disabled { opacity: .6; cursor: wait; transform: none; }

        .date-selection-note {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 9px;
            background: #fdf4f4;
            color: #7b1e2b;
            font-size: 10px;
            line-height: 1.5;
        }

        .rental-date-control label {
            display: block;
            margin-bottom: 5px;
            color: #55514e;
            font-size: 10px;
            font-weight: 800;
        }

        .rental-date-control input {
            width: 100%;
            min-height: 42px;
            padding: 0 11px;
            border: 1px solid var(--line);
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: var(--text);
            font-size: 12px;
        }

        .rental-date-control input:focus {
            border-color: #c9c3be;
            box-shadow: 0 0 0 3px rgba(207,32,43,.06);
        }

        .rental-date-control small {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 9px;
        }

        /* =========================
           CONTENT / FILTER
           ========================= */

        .collection-content {
            width: min(1180px, calc(100% - 40px));
            margin: auto;
            padding: 42px 0 80px;
        }

        .collection-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .result-count {
            color: #55514e;
            font-size: 13px;
        }

        .result-count strong {
            color: var(--black);
        }

        .filters {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            width: 250px;
        }

        .search-box .material-symbols-outlined {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b8783;
            font-size: 19px;
        }

        .search-box input {
            width: 100%;
            height: 42px;
            padding: 0 13px 0 42px;
            border: 1px solid var(--line);
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: var(--text);
            font-size: 12px;
        }

        .search-box input:focus {
            border-color: #c9c3be;
            box-shadow: 0 0 0 3px rgba(207,32,43,.06);
        }

        .filter-select {
            height: 42px;
            padding: 0 34px 0 13px;
            border: 1px solid var(--line);
            border-radius: 8px;
            outline: none;
            color: #55514e;
            background: #fff;
            font-size: 12px;
        }

        /* =========================
           GRID KOSTUM
           ========================= */

        .costume-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .costume-card {
            overflow: visible;
            border: 0;
            border-radius: 0;
            background: transparent;
            transition: transform .2s ease;
        }

        .costume-card:hover {
            transform: translateY(-4px);
        }

        .costume-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4 / 3;
            background: #efedea;
            border-radius: 13px;
        }

        .costume-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .costume-card:hover .costume-image img {
            transform: scale(1.035);
        }

        .costume-card.is-unavailable .costume-image img {
            filter: grayscale(1) blur(1.2px);
            opacity: .48;
            transform: scale(1.015);
        }

        .costume-card.is-unavailable .costume-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(70, 66, 62, .20);
            pointer-events: none;
        }

        .costume-card.is-unavailable .status.unavailable {
            z-index: 2;
            background: rgba(55, 52, 49, .92);
        }

        .stock-context {
            margin-top: 12px;
            font-size: 10px;
            color: #8c847b;
        }

        .costume-code {
            display: inline-flex;
            margin-bottom: 7px;
            color: var(--red);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
        }

        .costume-image-detail {
            position: absolute;
            inset: 0;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: #fff;
            background: rgba(31, 22, 23, .48);
            font-size: 12px;
            font-weight: 800;
            opacity: 0;
            text-decoration: none;
            transition: opacity .2s ease;
        }

        .costume-image-detail .material-symbols-outlined { font-size: 19px; }
        .costume-card:hover .costume-image-detail,
        .costume-image:focus-within .costume-image-detail { opacity: 1; }

        .status {
            position: absolute;
            right: 12px;
            top: 12px;
            padding: 6px 9px;
            border-radius: 5px;
            background: #fff;
            color: #2d7a4b;
            font-size: 10px;
            font-weight: 800;
        }

        .status.limited {
            color: #a25c17;
        }

        .status.neutral {
            color: #665f59;
            background: #f2eee9;
        }

        .status.unavailable {
            color: #666;
            background: #eee;
        }

        .availability-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 6px;
            margin-bottom: 14px;
        }

        .availability-summary > div {
            padding: 7px 5px;
            border: 1px solid #eeeae7;
            border-radius: 7px;
            background: #fff;
            text-align: center;
        }

        .availability-summary span {
            display: block;
            color: #8a8580;
            font-size: 8px;
            line-height: 1.25;
        }

        .availability-summary strong {
            display: block;
            margin-top: 2px;
            color: var(--black);
            font-family: Montserrat, sans-serif;
            font-size: 13px;
        }

        .costume-body {
            padding: 14px 2px 4px;
        }

        .costume-category {
            margin-bottom: 7px;
            color: #99938e;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .costume-body h2 {
            margin: 0 0 14px;
            color: var(--black);
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            line-height: 1.35;
        }

        /* =========================
           SET INFO
           ========================= */

        .set-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 18px;
            padding: 11px 12px;
            border: 1px solid #ebe7e3;
            border-radius: 8px;
            background: var(--cream);
        }

        .set-info-main {
            color: var(--black);
            font-size: 11px;
            font-weight: 800;
        }

        .set-info-note {
            margin-top: 3px;
            color: #8a8580;
            font-size: 9px;
            font-weight: 500;
        }

        .set-info-number {
            flex-shrink: 0;
            color: var(--red);
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            font-weight: 800;
        }

        .costume-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding-top: 4px;
        }

        .detail-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--black);
            font-size: 11px;
            font-weight: 800;
        }

        .detail-link .material-symbols-outlined {
            font-size: 16px;
            transition: transform .2s ease;
        }

        .detail-link:hover .material-symbols-outlined {
            transform: translateX(3px);
        }

        .detail-link:hover { color: var(--red); }

        .rent-link {
            padding: 9px 14px;
            color: #fff;
            background: var(--black);
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
        }

        .rent-link:hover {
            background: var(--red);
        }

        .rent-link.disabled {
            display: inline-flex;
            justify-content: center;
            background: #d5d2cf;
            color: #fff;
            cursor: not-allowed;
        }

        .empty-state {
            grid-column: 1 / -1;
            padding: 70px 20px;
            border: 1px dashed #d8d2ce;
            border-radius: 12px;
            text-align: center;
            color: var(--muted);
        }

        /* =========================
           INFO BAND
           ========================= */

        .collection-info {
            margin-top: 58px;
            padding: 34px 38px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            align-items: center;
            background: var(--black);
            border-radius: 14px;
        }

        .collection-info h2 {
            margin: 0 0 9px;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 23px;
        }

        .collection-info p {
            margin: 0;
            color: #aaa;
            font-size: 12px;
            line-height: 1.7;
        }

        .info-points {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .info-point {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ddd;
            font-size: 11px;
        }

        .info-point .material-symbols-outlined {
            color: #ef4b54;
            font-size: 18px;
        }

        /* =========================
           FOOTER HITAM
           ========================= */

        .site-footer {
            padding: 56px 0 30px;
            color: #fff;
            background: #111;
        }

        .footer-inner {
            width: min(1180px, calc(100% - 40px));
            margin: auto;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 60px;
        }

        .footer-brand-column .footer-logo {
            width: 145px;
            height: auto;
            display: block;
            filter: brightness(0) invert(1);
        }

        .footer-desc {
            max-width: 330px;
            margin: 15px 0 0;
            color: #999;
            font-size: 12px;
            line-height: 1.7;
        }

        .footer-title {
            margin: 0 0 15px;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            color: #999;
            font-size: 12px;
        }

        .footer-links a:hover {
            color: #ef4b54;
        }

        .footer-bottom {
            width: min(1180px, calc(100% - 40px));
            margin: 40px auto 0;
            padding-top: 22px;
            border-top: 1px solid #272727;
            color: #666;
            font-size: 10px;
        }

        /* =========================
           RESPONSIVE
           ========================= */

        @media (max-width: 1050px) {
            .costume-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 820px) {
            .collection-nav-inner {
                min-height: 68px;
            }

            .nav-links {
                display: none;
            }

            .collection-hero-inner {
                padding: 55px 0 50px;
            }

            .collection-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .filters {
                width: 100%;
            }

            .search-box {
                flex: 1;
                width: auto;
            }

            .collection-info {
                grid-template-columns: 1fr;
            }

            .footer-inner {
                grid-template-columns: 1fr 1fr;
                gap: 35px;
            }

            .footer-brand-column {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 620px) {
            .rental-date-panel {
                align-items: stretch;
                flex-direction: column;
                gap: 14px;
                padding: 15px;
            }

            .rental-date-control {
                width: 100%;
            }

            .rental-date-control input {
                min-height: 46px;
                font-size: 14px;
                min-width: 0;
            }

            .rental-date-actions { width: 100%; }
            .rental-date-actions input { flex: 1; }
            .date-apply-button { min-width: 62px; min-height: 46px; }

            .collection-nav-inner,
            .collection-hero-inner,
            .collection-content,
            .footer-inner,
            .footer-bottom {
                width: min(100% - 28px, 1180px);
            }

            .nav-action {
                display: none;
            }

            .collection-hero h1 {
                font-size: 38px;
            }

            .collection-hero p {
                font-size: 13px;
            }

            .costume-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .costume-body {
                padding: 12px 2px 4px;
            }

            .costume-body h2 {
                font-size: 13px;
            }

            .set-info {
                align-items: flex-start;
            }

            .set-info-number {
                font-size: 14px;
            }

            .costume-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .rent-link {
                text-align: center;
            }

            .collection-info {
                padding: 25px 20px;
            }

            .info-points {
                grid-template-columns: 1fr;
            }

            .footer-inner {
                grid-template-columns: 1fr;
            }

            .footer-brand-column {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

<div class="collection-page">

    
    <?php echo $__env->make('partials.user-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <section class="collection-hero">

        <div class="collection-hero-inner">

            <div class="eyebrow">
                Koleksi Sebajar.id
            </div>

            <h1>
                Temukan Kostum Saman
                <span>yang Tepat.</span>
            </h1>

            <p>
                Jelajahi koleksi kostum Tari Saman Sebajar.id.
                Setiap koleksi tersedia dalam satuan set kostum,
                dengan detail warna dan ukuran yang dapat dilihat
                pada halaman detail sebelum mengajukan penyewaan.
            </p>

        </div>

    </section>

    
    <main class="collection-content">

        <section class="rental-date-panel" aria-labelledby="rentalDateTitle">
            <div class="rental-date-copy">
                <span class="material-symbols-outlined" aria-hidden="true">calendar_month</span>
                <div>
                    <h2 id="rentalDateTitle">Pilih tanggal sewa</h2>
                    <p>Pilih tanggal lalu tekan <strong>OK</strong> untuk memuat ulang stok sesuai tanggal tersebut.</p>
                </div>
            </div>

            <div class="rental-date-control">
                <label for="rentalDate">Tanggal sewa</label>
                <div class="rental-date-actions">
                    <input
                        type="date"
                        id="rentalDate"
                        value="<?php echo e($rentalDate); ?>"
                        min="<?php echo e(now()->format('Y-m-d')); ?>"
                        aria-describedby="rentalDateHint"
                    >
                    <button type="button" id="applyRentalDate" class="date-apply-button">OK</button>
                </div>
                <small id="rentalDateHint">
                    <?php echo e($rentalDate ? 'Stok sudah dihitung untuk tanggal ini.' : 'Belum ada tanggal yang dipilih.'); ?>

                </small>
            </div>
        </section>

        <div class="collection-toolbar">

            <div class="result-count">
                Menampilkan
                <strong id="resultCount"><?php echo e(count($costumes)); ?></strong>
                koleksi kostum
            </div>

            <div class="filters">

                <div class="search-box">

                    <span class="material-symbols-outlined">
                        search
                    </span>

                    <input
                        type="search"
                        id="costumeSearch"
                        placeholder="Cari kode atau warna..."
                        aria-label="Cari koleksi kostum"
                    >

                </div>

                <select
                    id="statusFilter"
                    class="filter-select"
                    aria-label="Filter status"
                >
                    <option value="all">Semua Status</option>
                    <option value="available">Tersedia</option>
                    <option value="limited">Terbatas</option>
                </select>

            </div>

        </div>

        <div
            class="costume-grid"
            id="costumeGrid"
        >

            <?php $__currentLoopData = $costumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php
                    $code = $getValue($costume, 'code', '-');
                    $name = $getValue($costume, 'name', 'Kostum');
                    $category = $getValue($costume, 'category', 'Kostum Saman');
                    $status = $getValue($costume, 'status', 'active');
                    $imageUrl = $getImageUrl($costume);
                    $availability = $getAvailability($costume);

                    $totalStock = (int) ($availability['total'] ?? 0);
                    $reservedStock = (int) ($availability['reserved'] ?? 0);
                    $availableStock = (int) ($availability['available'] ?? 0);

                    $hasDate = filled($rentalDate);
                    $isInactive = strtolower((string) $status) === 'inactive';
                    $isOutOfStock = $hasDate && ($isInactive || $availableStock <= 0);
                    $isLimited = $hasDate && !$isOutOfStock && $availableStock < $totalStock;

                    $displayStatus = !$hasDate
                        ? 'Pilih Tanggal'
                        : ($isInactive
                            ? 'Tidak Tersedia'
                            : ($isOutOfStock
                                ? 'Sedang Disewa'
                                : ($isLimited ? 'Stok Terbatas' : 'Tersedia')));
                ?>

                <article
                    class="costume-card <?php echo e($isOutOfStock ? 'is-unavailable' : ''); ?>"
                    data-name="<?php echo e(strtolower($name)); ?>"
                    data-code="<?php echo e(strtolower($code)); ?>"
                    data-status="<?php echo e($isOutOfStock ? 'unavailable' : ($isLimited ? 'limited' : 'available')); ?>"
                >

                    <div class="costume-image">
                        
                        <?php if($imageUrl): ?>
                            <img
                                src="<?php echo e($imageUrl); ?>"
                                alt="Kostum Tari Saman <?php echo e($code); ?> - <?php echo e($name); ?>"
                                loading="lazy"
                            >
                        <?php else: ?>
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#999;background:#efedea;font-size:12px;">
                                Belum ada gambar
                            </div>
                        <?php endif; ?>

                        <span class="status <?php echo e(!$hasDate ? 'neutral' : ($isOutOfStock ? 'unavailable' : ($isLimited ? 'limited' : ''))); ?>">
                            <?php echo e($displayStatus); ?>

                        </span>

                        <a href="<?php echo e(url('/koleksi/' . rawurlencode($code))); ?>" class="costume-image-detail" aria-label="Lihat detail <?php echo e($name); ?>">
                            <span class="material-symbols-outlined" aria-hidden="true">visibility</span>
                            <span>Lihat Detail</span>
                        </a>

                    </div>

                    <div class="costume-body">

                        <span class="costume-code"><?php echo e($code); ?></span>

                        <div class="costume-category">
                            <?php echo e($category); ?>

                        </div>

                        <h2>
                            <?php echo e($name); ?>

                        </h2>

                        
                        <div class="set-info">
                            <div>
                                <div class="set-info-main">Kostum 1 Set</div>
                                <div class="set-info-note">1 baju + 1 celana</div>
                            </div>

                            <div class="set-info-number">
                                <?php echo e($availableStock); ?> Set
                            </div>
                        </div>

                        <div class="stock-context"><?php echo e($rentalDate ? 'Ketersediaan untuk ' . \Carbon\Carbon::parse($rentalDate)->translatedFormat('d F Y') : 'Pilih tanggal untuk melihat stok aktual.'); ?></div>

                        <div class="availability-summary">
                            <div>
                                <span>Tersedia</span>
                                <strong><?php echo e($availableStock); ?></strong>
                            </div>
                            <div>
                                <span>Sedang disewa</span>
                                <strong><?php echo e($reservedStock); ?></strong>
                            </div>
                            <div>
                                <span>Total</span>
                                <strong><?php echo e($totalStock); ?></strong>
                            </div>
                        </div>

                        <div class="costume-footer">

                            <a
                                href="<?php echo e(url('/koleksi/' . rawurlencode($code))); ?>"
                                class="detail-link"
                            >
                                Lihat Detail

                                <span class="material-symbols-outlined">
                                    arrow_forward
                                </span>
                            </a>

                            <?php if(!$isOutOfStock): ?>
                                <a
                                    href="<?php echo e(url('/penyewaan?kostum=' . rawurlencode($code) . ($rentalDate ? '&rental_date=' . rawurlencode($rentalDate) : ''))); ?>"
                                    class="rent-link"
                                    data-rental-link
                                >
                                    Ajukan Sewa
                                </a>
                            <?php else: ?>
                                <span class="rent-link disabled">
                                    Stok Tidak Tersedia
                                </span>
                            <?php endif; ?>

                        </div>

                    </div>

                </article>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div
                class="empty-state"
                id="emptyState"
                hidden
            >
                <strong>
                    Kostum tidak ditemukan.
                </strong>

                <br>

                <span>
                    Coba gunakan kata kunci atau filter yang berbeda.
                </span>
            </div>

        </div>

        
        <section class="collection-info">

            <div>

                <h2>
                    Belum yakin memilih kostum?
                </h2>

                <p>
                    Tidak perlu bingung. Tim Sebajar.id dapat membantu
                    menyesuaikan pilihan kostum dengan kebutuhan jumlah
                    anggota, warna, ukuran, dan jadwal penyewaan.
                    Detail ukuran baju dan celana dapat dilihat pada
                    halaman masing-masing kostum.
                </p>

            </div>

            <div class="info-points">

                <div class="info-point">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>

                    Pilihan warna beragam

                </div>

                <div class="info-point">

                    <span class="material-symbols-outlined">
                        straighten
                    </span>

                    Ukuran baju & celana

                </div>

                <div class="info-point">

                    <span class="material-symbols-outlined">
                        inventory_2
                    </span>

                    Informasi ketersediaan

                </div>

                <div class="info-point">

                    <span class="material-symbols-outlined">
                        support_agent
                    </span>

                    Bantuan dari admin

                </div>

            </div>

        </section>

    </main>

    
    <footer class="site-footer">

        <div class="footer-inner">

            <div class="footer-brand-column">

                <img
                    src="<?php echo e(asset('images/sebajar-logo.png')); ?>"
                    alt="Sebajar.id"
                    class="footer-logo"
                >

                <p class="footer-desc">
                    Platform penyewaan kostum Tari Saman untuk membantu
                    kebutuhan pertunjukan, lomba, sekolah, komunitas,
                    dan kegiatan seni.
                </p>

            </div>

            <div>

                <h3 class="footer-title">
                    Navigasi
                </h3>

                <div class="footer-links">

                    <a href="<?php echo e(url('/')); ?>">
                        Beranda
                    </a>

                    <a href="<?php echo e(url('/koleksi')); ?>">
                        Koleksi
                    </a>

                    <a href="<?php echo e(url('/#cara-sewa')); ?>">
                        Cara Sewa
                    </a>

                    <a href="<?php echo e(url('/#tentang')); ?>">
                        Tentang Kami
                    </a>

                </div>

            </div>

            <div>

                <h3 class="footer-title">
                    Bantuan
                </h3>

                <div class="footer-links">

                    <a href="<?php echo e($whatsappUrl); ?>">
                        Hubungi Admin
                    </a>

                    <a href="<?php echo e(url('/#cara-sewa')); ?>">
                        Panduan Penyewaan
                    </a>

                    <a href="<?php echo e(url('/login')); ?>">
                        Masuk
                    </a>

                    <a href="<?php echo e(url('/register')); ?>">
                        Daftar
                    </a>

                </div>

            </div>

        </div>

        <div class="footer-bottom">
            © <?php echo e(date('Y')); ?> Sebajar.id. Seluruh hak cipta dilindungi.
        </div>

    </footer>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('costumeSearch');
    const statusFilter = document.getElementById('statusFilter');
    const rentalDate = document.getElementById('rentalDate');
    const rentalDateHint = document.getElementById('rentalDateHint');
    const cards = Array.from(document.querySelectorAll('.costume-card'));
    const emptyState = document.getElementById('emptyState');
    const resultCount = document.getElementById('resultCount');

    function updateRentalLinks() {
        const date = rentalDate ? rentalDate.value : '';

        document.querySelectorAll('[data-rental-link]').forEach(function (link) {
            const url = new URL(link.href, window.location.origin);

            if (date) {
                url.searchParams.set('rental_date', date);
            } else {
                url.searchParams.delete('rental_date');
            }

            link.href = url.toString();
        });

        if (!rentalDateHint) {
            return;
        }

        if (!date) {
            rentalDateHint.textContent =
                'Pilih tanggal sebelum mengajukan sewa.';
            return;
        }

        const formatted = new Date(
            date + 'T00:00:00'
        ).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        rentalDateHint.textContent =
            'Tanggal ' + formatted + ' dipilih.';
    }

    function filterCostumes() {
        const keyword = searchInput?.value.trim().toLowerCase() || '';
        const status = statusFilter?.value || 'all';
        let visible = 0;

        cards.forEach(function (card) {
            const name = card.dataset.name || '';
            const code = card.dataset.code || '';
            const cardStatus = card.dataset.status || '';

            const matchKeyword =
                !keyword ||
                name.includes(keyword) ||
                code.includes(keyword);

            const matchStatus =
                status === 'all' ||
                cardStatus === status;

            const show = matchKeyword && matchStatus;

            card.hidden = !show;

            if (show) {
                visible++;
            }
        });

        if (resultCount) {
            resultCount.textContent = visible;
        }

        if (emptyState) {
            emptyState.hidden = visible !== 0;
        }
    }

    const applyDateButton = document.getElementById('applyRentalDate');

    applyDateButton?.addEventListener('click', function () {
        const date = rentalDate?.value || '';
        const today = new Date().toISOString().split('T')[0];

        if (!date) {
            rentalDate?.focus();
            rentalDateHint.textContent = 'Pilih tanggal terlebih dahulu.';
            return;
        }

        if (date < today) {
            rentalDateHint.textContent = 'Tanggal sewa tidak boleh sebelum hari ini.';
            return;
        }

        const url = new URL(window.location.href);
        url.searchParams.set('rental_date', date);
        applyDateButton.disabled = true;
        applyDateButton.textContent = '...';
        window.location.assign(url.toString());
    });

    rentalDate?.addEventListener('change', function () {
        if (rentalDateHint) rentalDateHint.textContent = 'Tekan OK untuk memperbarui stok.';
    });

    searchInput?.addEventListener('input', filterCostumes);
    statusFilter?.addEventListener('change', filterCostumes);

    document.addEventListener('click', function (event) {
        const link = event.target.closest('[data-rental-link]');

        if (!link || rentalDate?.value) {
            return;
        }

        event.preventDefault();

        rentalDate?.focus();
        rentalDate?.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    });

    updateRentalLinks();
});
</script>

</body>
</html>
<?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/koleksi.blade.php ENDPATH**/ ?>