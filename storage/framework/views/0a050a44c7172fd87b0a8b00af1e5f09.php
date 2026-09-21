<?php
    use App\Models\Costume;
    use App\Services\RentalAvailabilityService;

    /*
    |--------------------------------------------------------------------------
    | Kostum yang dipilih
    |--------------------------------------------------------------------------
    |
    | Ambil dari:
    | 1. Query ?kostum=SBJ-001
    | 2. Input sebelumnya saat validasi gagal
    | 3. Fallback ke SBJ-001
    |
    */

    $selectedCode = strtoupper(
        str_replace(
            ' ',
            '-',
            old(
                'costume_code',
                request('kostum', 'SBJ-001')
            )
        )
    );

    $costume = $costume
        ?? Costume::where('code', $selectedCode)
            ->with('sizes')
            ->first();

    /*
    |--------------------------------------------------------------------------
    | Fallback jika kode kostum tidak ditemukan
    |--------------------------------------------------------------------------
    */

    if (!$costume) {
        $costume = Costume::with('sizes')->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | Stok fisik awal
    |--------------------------------------------------------------------------
    */

    $availabilityService = app(RentalAvailabilityService::class);

    $stockSets = $stockSets
        ?? $availabilityService->getTotalStock($costume);

    $rentalDate = $rentalDate
        ?? old('rental_date', request('rental_date'));

    $availableStock = $availabilityService->getAvailableStock(
        $costume,
        $rentalDate
    );

    $availableSizes = $availabilityService->getAvailableSizeStock(
        $costume,
        $rentalDate
    );

    $adminWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $whatsappUrl = $adminWhatsapp ? 'https://wa.me/' . $adminWhatsapp . '?text=' . rawurlencode('Halo Admin Sebajar, saya ingin bertanya mengenai penyewaan kostum.') : '#';

    /*
    |--------------------------------------------------------------------------
    | Ukuran kostum
    |--------------------------------------------------------------------------
    | Ambil hanya ukuran yang benar-benar tercatat pada costume_sizes.
    | Nilai quantity dipakai sebagai batas fisik awal pilihan ukuran.
    */
    $shirtSizes = $costume->sizes
        ->where('category', 'baju')
        ->filter(fn ($size) => (int) $size->quantity > 0)
        ->sortBy('size');

    $pantsSizes = $costume->sizes
        ->where('category', 'celana')
        ->filter(fn ($size) => (int) $size->quantity > 0)
        ->sortBy('size');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        rel="icon"
        type="image/png"
        href="<?php echo e(asset('images/sebajar-logo.png')); ?>"
    >

    <title>Sebajar.id — Ajukan Penyewaan</title>

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

    <link
        rel="stylesheet"
        href="<?php echo e(asset('css/sebajar-home.css')); ?>"
    >

    <style>
        :root {
            --red: #cf202b;
            --red-dark: #aa1721;
            --black: #111;
            --text: #292725;
            --muted: #77716d;
            --line: #e7e2de;
            --cream: #f8f6f3;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--text);
            background: #fff;
            font-family: Inter, sans-serif;
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

        /* =========================
           NAVBAR
           ========================= */

        .rental-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,.97);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .rental-nav-inner {
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
        }

        .brand-logo {
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

        .nav-links a:hover {
            color: var(--red);
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
           MAIN
           ========================= */

        .rental-main {
            width: min(1050px, calc(100% - 40px));
            margin: auto;
            padding: 32px 0 80px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 28px;
            color: #8b8580;
            font-size: 11px;
        }

        .breadcrumb a:hover {
            color: var(--red);
        }

        .breadcrumb .material-symbols-outlined {
            font-size: 15px;
        }

        .page-heading {
            margin-bottom: 30px;
        }

        .eyebrow {
            margin-bottom: 9px;
            color: var(--red);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .page-heading h1 {
            margin: 0 0 9px;
            color: var(--black);
            font-family: Montserrat, sans-serif;
            font-size: clamp(30px, 4vw, 43px);
            line-height: 1.1;
            letter-spacing: -.04em;
        }

        .page-heading p {
            max-width: 650px;
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.75;
        }

        /* =========================
           LAYOUT
           ========================= */

        .rental-layout {
            display: grid;
            grid-template-columns: 330px minmax(0, 1fr);
            gap: 30px;
            align-items: start;
        }

        .selected-card {
            position: sticky;
            top: 105px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: #fff;
        }

        .selected-image {
            aspect-ratio: 1 / .84;
            overflow: hidden;
            background: #efedea;
        }

        .selected-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .selected-content {
            padding: 20px;
        }

        .selected-label {
            margin-bottom: 7px;
            color: var(--red);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .selected-content h2 {
            margin: 0 0 5px;
            color: var(--black);
            font-family: Montserrat, sans-serif;
            font-size: 21px;
        }

        .selected-code {
            margin-bottom: 16px;
            color: #99928d;
            font-size: 10px;
            font-weight: 700;
        }

        .selected-info {
            display: flex;
            align-items: center;
            gap: 7px;
            padding-top: 14px;
            border-top: 1px solid var(--line);
            color: #4e4945;
            font-size: 11px;
        }

        .selected-info .material-symbols-outlined {
            color: var(--red);
            font-size: 17px;
        }

        .change-link {
            display: inline-block;
            margin-top: 16px;
            color: var(--red);
            font-size: 10px;
            font-weight: 800;
        }

        /* =========================
           FORM
           ========================= */

        .form-card {
            padding: 28px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: #fff;
        }

        .form-section + .form-section {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid var(--line);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .section-number {
            width: 26px;
            height: 26px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 50%;
            color: #fff;
            background: var(--red);
            font-size: 10px;
            font-weight: 800;
        }

        .section-title h2 {
            margin: 0;
            color: var(--black);
            font-family: Montserrat, sans-serif;
            font-size: 16px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            color: #36322f;
            font-size: 10px;
            font-weight: 800;
        }

        .required {
            color: var(--red);
        }

        .form-control {
            width: 100%;
            min-height: 43px;
            padding: 0 12px;
            outline: none;
            border: 1px solid #dcd7d3;
            border-radius: 7px;
            color: #3b3734;
            background: #fff;
            font-size: 11px;
            transition: .18s;
        }

        .form-control:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(207,32,43,.08);
        }

        .form-help {
            margin-top: 6px;
            color: #98918c;
            font-size: 9px;
            line-height: 1.5;
        }

        .date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* =========================
           JUMLAH SET
           ========================= */

        .quantity-panel {
            padding: 17px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--cream);
        }

        .quantity-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 13px;
        }

        .quantity-heading strong {
            color: #36322f;
            font-size: 11px;
        }

        .stock-note {
            color: #8f8984;
            font-size: 9px;
        }

        .quantity-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-top: 1px solid #e5e0dc;
        }

        .quantity-label {
            color: #36322f;
            font-size: 11px;
            font-weight: 700;
        }

        .quantity-description {
            display: block;
            margin-top: 3px;
            color: #9a938e;
            font-size: 9px;
            font-weight: 400;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .quantity-button {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border: 1px solid #dcd7d3;
            border-radius: 6px;
            color: #55514e;
            background: #fff;
            cursor: pointer;
        }

        .quantity-button:hover {
            color: var(--red);
            border-color: var(--red);
        }

        .quantity-input {
            width: 55px;
            height: 35px;
            padding: 0 7px;
            text-align: center;
            outline: none;
            border: 1px solid #dcd7d3;
            border-radius: 6px;
            color: var(--black);
            background: #fff;
            font-size: 11px;
            font-weight: 700;
        }

        .total-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
            padding: 13px 15px;
            border-radius: 7px;
            background: #fdf4f4;
        }

        .total-label {
            color: #6f6965;
            font-size: 10px;
            font-weight: 700;
        }

        .total-value {
            color: var(--red);
            font-size: 15px;
            font-weight: 800;
        }

        .notice {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 19px;
            padding: 13px;
            border-radius: 7px;
            background: #f7f5f2;
            color: #77716d;
            font-size: 10px;
            line-height: 1.6;
        }

        .notice .material-symbols-outlined {
            color: var(--red);
            font-size: 17px;
        }

        .availability-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 12px;
            padding: 13px;
            border: 1px solid var(--line);
            border-radius: 7px;
            background: #f7f5f2;
        }

        .availability-box .material-symbols-outlined {
            color: var(--red);
            font-size: 18px;
            flex: 0 0 auto;
        }

        .availability-box strong {
            display: block;
            margin-bottom: 3px;
            color: #36322f;
            font-size: 10px;
        }

        .availability-box-message {
            display: block;
            color: #77716d;
            font-size: 9px;
            line-height: 1.5;
        }
        /* =========================
           UKURAN KOSTUM
           ========================= */

        .size-selection {
            margin-top: 20px;
            padding: 17px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
        }

        .size-selection-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .size-selection-header strong {
            display: block;
            color: #36322f;
            font-size: 11px;
        }

        .size-selection-header span {
            color: #8f8984;
            font-size: 9px;
            line-height: 1.5;
            text-align: right;
        }

        .size-category + .size-category {
            margin-top: 18px;
            padding-top: 17px;
            border-top: 1px solid var(--line);
        }

        .size-category-title {
            margin-bottom: 9px;
            color: #36322f;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .size-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .size-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 48px;
            padding: 8px 10px;
            border: 1px solid #e1dcd8;
            border-radius: 7px;
            background: #faf9f7;
        }

        .size-name {
            color: #3b3734;
            font-size: 10px;
            font-weight: 800;
        }

        .size-stock {
            display: block;
            margin-top: 2px;
            color: #9a938e;
            font-size: 8px;
        }

        .size-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .size-button {
            width: 25px;
            height: 25px;
            display: grid;
            place-items: center;
            border: 1px solid #dcd7d3;
            border-radius: 5px;
            color: #55514e;
            background: #fff;
            cursor: pointer;
            line-height: 1;
        }

        .size-button:hover {
            color: var(--red);
            border-color: var(--red);
        }

        .size-input {
            width: 38px;
            height: 28px;
            padding: 0 4px;
            text-align: center;
            outline: none;
            border: 1px solid #dcd7d3;
            border-radius: 5px;
            color: var(--black);
            background: #fff;
            font-size: 10px;
            font-weight: 700;
        }

        .size-input:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(207,32,43,.08);
        }

        .size-summary {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 13px;
            padding: 10px 12px;
            border-radius: 6px;
            background: #f7f5f2;
            color: #77716d;
            font-size: 9px;
        }

        .size-summary strong {
            color: #36322f;
        }

        .size-summary.is-valid {
            background: #edf9f0;
            color: #245b30;
        }

        .size-summary.is-invalid {
            background: #fdf4f4;
            color: var(--red-dark);
        }

        .size-error {
            display: none;
            margin-top: 8px;
            color: var(--red);
            font-size: 9px;
            line-height: 1.5;
        }

        .size-error.visible {
            display: block;
        }

        .success-notification {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 28px;
            padding: 17px 18px;
            border: 1px solid #b7dfc0;
            border-radius: 10px;
            background: #edf9f0;
            color: #245b30;
            animation: successSlideDown .35s ease;
        }

        .success-icon {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 50%;
            color: #fff;
            background: #28a745;
        }

        .success-icon .material-symbols-outlined {
            font-size: 18px;
            font-weight: 700;
        }

        .success-content {
            padding-right: 25px;
        }

        .success-content strong {
            display: block;
            margin-bottom: 4px;
            color: #1e572b;
            font-size: 12px;
            font-weight: 800;
        }

        .success-content p {
            margin: 0;
            color: #4c7153;
            font-size: 10px;
            line-height: 1.6;
        }

        .success-close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 5px;
            color: #5f8065;
            background: transparent;
            cursor: pointer;
        }

        .success-close:hover {
            color: #245b30;
            background: #dff2e3;
        }

        .success-close .material-symbols-outlined {
            font-size: 17px;
        }

        @keyframes successSlideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* =========================
           SUBMIT
           ========================= */

        .submit-area {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--line);
        }

        .submit-check {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 18px;
            color: #77716d;
            font-size: 10px;
            line-height: 1.55;
        }

        .submit-check input {
            margin-top: 2px;
            accent-color: var(--red);
        }

        .submit-button {
            width: 100%;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 7px;
            color: #fff;
            background: var(--red);
            cursor: pointer;
            font-size: 11px;
            font-weight: 800;
        }

        .submit-button:hover {
            background: var(--red-dark);
        }

        .submit-button:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .submit-button .material-symbols-outlined {
            font-size: 18px;
        }

        .after-submit {
            margin-top: 10px;
            text-align: center;
            color: #9a938e;
            font-size: 9px;
            line-height: 1.5;
        }

        .selected-date-box {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 66px;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--cream);
        }

        .rental-date-input-wrap { flex: 1; min-width: 0; }
        .rental-date-input-wrap input {
            width: 100%;
            min-height: 43px;
            padding: 0 11px;
            border: 1px solid #dcd7d3;
            border-radius: 8px;
            outline: none;
            background: #fff;
            color: var(--black);
            font-size: 12px;
        }
        .rental-date-input-wrap input:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(207,32,43,.08); }
        .date-change-note { margin-top: 5px; color: #8f8984; font-size: 9px; line-height: 1.5; }

        .selected-date-box > .material-symbols-outlined {
            flex: 0 0 auto;
            color: var(--red);
            font-size: 24px;
        }

        .selected-date-box strong {
            color: var(--black);
            font-family: Montserrat, sans-serif;
            font-size: 13px;
        }

        .change-date-link {
            margin-left: auto;
            flex: 0 0 auto;
            color: var(--red);
            font-size: 10px;
            font-weight: 800;
        }

        /* =========================
           HELP / FOOTER
           ========================= */

        .help-band {
            margin-top: 70px;
            padding: 31px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            border-radius: 13px;
            color: #fff;
            background: var(--black);
        }

        .help-band h2 {
            margin: 0 0 7px;
            font-family: Montserrat, sans-serif;
            font-size: 19px;
        }

        .help-band p {
            max-width: 620px;
            margin: 0;
            color: #a9a5a2;
            font-size: 10px;
            line-height: 1.7;
        }

        .help-button {
            flex: 0 0 auto;
            padding: 12px 18px;
            border-radius: 7px;
            color: #fff;
            background: var(--red);
            font-size: 10px;
            font-weight: 800;
        }

        .site-footer {
            padding: 54px 0 28px;
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

        .footer-brand-logo {
            width: 145px;
            height: auto;
            display: block;
            filter: brightness(0) invert(1);
        }

        .footer-desc {
            max-width: 330px;
            margin: 15px 0 0;
            color: #999;
            font-size: 11px;
            line-height: 1.7;
        }

        .footer-title {
            margin: 0 0 15px;
            color: #fff;
            font-size: 10px;
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
            font-size: 11px;
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
            font-size: 9px;
        }

        /* =========================
           RESPONSIVE
           ========================= */

        @media (max-width: 900px) {
            .nav-links {
                display: none;
            }

            .rental-layout {
                grid-template-columns: 1fr;
            }

            .selected-card {
                position: static;
                display: grid;
                grid-template-columns: 210px 1fr;
            }

            .selected-image {
                height: 100%;
                aspect-ratio: auto;
            }

            .footer-inner {
                grid-template-columns: 1fr 1fr;
                gap: 35px;
            }
        }

        @media (max-width: 620px) {
            .rental-nav-inner,
            .rental-main,
            .footer-inner,
            .footer-bottom {
                width: calc(100% - 28px);
            }

            .brand-logo {
                width: 125px;
            }

            .nav-action {
                display: none;
            }

            .rental-main {
                padding-top: 22px;
            }

            .form-card {
                padding: 20px 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .date-row {
                grid-template-columns: 1fr;
            }

            .selected-card {
                display: block;
            }

            .selected-image {
                aspect-ratio: 1 / .75;
            }

            .quantity-row {
                align-items: flex-start;
            }

            .help-band {
                align-items: flex-start;
                flex-direction: column;
                padding: 25px 21px;
            }

            .help-button {
                width: 100%;
                text-align: center;
            }

            .footer-inner {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<?php echo $__env->make('partials.user-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main class="rental-main">
        <?php if(session('success')): ?>
    <div class="success-notification" id="successNotification">
        <div class="success-icon">
            <span class="material-symbols-outlined">
                check
            </span>
        </div>

        <div class="success-content">
            <strong>Pengajuan Berhasil</strong>

            <p>
                <?php echo e(session('success')); ?>

            </p>
        </div>

        <button
            type="button"
            class="success-close"
            onclick="closeSuccessNotification()"
            aria-label="Tutup notifikasi"
        >
            <span class="material-symbols-outlined">
                close
            </span>
        </button>
    </div>
<?php endif; ?>
    <div class="breadcrumb">

        <a href="<?php echo e(url('/')); ?>">
            Beranda
        </a>

        <span class="material-symbols-outlined">
            chevron_right
        </span>

        <a href="<?php echo e(url('/koleksi')); ?>">
            Koleksi
        </a>

        <span class="material-symbols-outlined">
            chevron_right
        </span>

        <span>
            Pengajuan Penyewaan
        </span>

    </div>

    <section class="page-heading">

        <div class="eyebrow">
            Sebajar.id · Penyewaan Kostum
        </div>

        <h1>
            Ajukan Penyewaan
        </h1>

        <p>
            Isi data singkat untuk mengajukan penyewaan kostum Tari Saman.
            Setelah pengajuan dikirim, tim Sebajar.id akan memeriksa
            ketersediaan dan menghubungi kamu melalui WhatsApp.
        </p>

    </section>

    <section class="rental-layout">

        
        <aside class="selected-card">

            <div class="selected-image">

                <img
                    src="<?php echo e($costume->image_url ?: asset('images/sebajar-logo.png')); ?>"
                    alt="<?php echo e($costume->code); ?> — <?php echo e($costume->name); ?>"
                >

            </div>

            <div class="selected-content">

                <div class="selected-label">
                    Kostum yang dipilih
                </div>

                <h2>
                    <?php echo e($costume->name); ?>

                </h2>

                <div class="selected-code">
                    <?php echo e($costume->code); ?> · Kostum Tari Saman
                </div>

                <div class="selected-info">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>

                    <span>
                        Ketersediaan mengikuti stok yang sedang terkunci
                    </span>

                </div>

                <a
                    href="<?php echo e(url('/koleksi')); ?>"
                    class="change-link"
                >
                    ← Pilih kostum lain
                </a>

            </div>

        </aside>

        
        <form
            class="form-card"
            method="POST"
            action="<?php echo e(url('/penyewaan')); ?>"
            id="rentalForm"
        >

            <?php echo csrf_field(); ?>

            
            <section class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        1
                    </span>

                    <h2>
                        Data Penyewa
                    </h2>

                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="customer_name"
                        >
                            Nama penyewa
                            <span class="required">*</span>
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            placeholder="Masukkan nama penyewa"
                            autocomplete="name"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="team_name"
                        >
                            Nama tim
                            <span class="required">*</span>
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            id="team_name"
                            name="team_name"
                            placeholder="Masukkan nama tim"
                            required
                        >

                    </div>

                    <div class="form-group full">

                        <label
                            class="form-label"
                            for="phone"
                        >
                            Nomor HP / WhatsApp
                            <span class="required">*</span>
                        </label>

                        <input
                            class="form-control"
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="08xxxxxxxxxx"
                            autocomplete="tel"
                            inputmode="tel"
                            required
                        >

                        <div class="form-help">
                            Nomor ini digunakan admin untuk menghubungi kamu
                            terkait pengajuan penyewaan.
                        </div>

                    </div>

                </div>

            </section>

            
            <section class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        2
                    </span>

                    <h2>
                        Detail Penyewaan
                    </h2>

                </div>

                <div class="form-grid">

                    <div class="form-group full">

                        <label class="form-label">
                            Jumlah set
                            <span class="required">*</span>
                        </label>

                        <div class="quantity-panel">

                            <div class="quantity-heading">

                                <strong>
                                    Kostum yang ingin disewa
                                </strong>

                                <span class="stock-note" id="availabilityText">
                                    Pilih tanggal untuk melihat ketersediaan
                                </span>

                            </div>

                            <div class="quantity-row">

                                <div>

                                    <div class="quantity-label">
                                        <?php echo e($costume->code); ?>

                                    </div>

                                    <span class="quantity-description">
                                        1 set terdiri dari 1 baju + 1 celana
                                    </span>

                                </div>

                                <div class="quantity-control">

                                    <button
                                        type="button"
                                        class="quantity-button"
                                        data-action="minus"
                                        aria-label="Kurangi jumlah set"
                                    >
                                        −
                                    </button>

                                    <input
                                        class="quantity-input"
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="<?php echo e($stockSets); ?>"
                                        aria-label="Jumlah set"
                                        required
                                    >

                                    <button
                                        type="button"
                                        class="quantity-button"
                                        data-action="plus"
                                        aria-label="Tambah jumlah set"
                                    >
                                        +
                                    </button>

                                </div>

                            </div>

                        </div>

                        <div class="total-box">

                            <span class="total-label">
                                Total pengajuan
                            </span>

                            <span
                                class="total-value"
                                id="totalCostume"
                            >
                                1 set
                            </span>

                        </div>

                        <div
                            id="availabilityBox"
                            class="availability-box"
                            aria-live="polite"
                        >
                            <span class="material-symbols-outlined">
                                calendar_month
                            </span>

                            <div>
                                <strong id="availabilityTitle">
                                    Ketersediaan kostum
                                </strong>

                                <span
                                    id="availabilityMessage"
                                    class="availability-box-message"
                                >
                                    Pilih tanggal sewa untuk melihat stok yang tersedia.
                                </span>
                            </div>
                        </div>

                        
                        <div class="size-selection">
                            <div class="size-selection-header">
                                <div>
                                    <strong>Ukuran yang disewa</strong>
                                    <div class="form-help">
                                        Tentukan jumlah untuk setiap ukuran. Total baju dan celana harus sama dengan jumlah set.
                                    </div>
                                </div>

                                <span>
                                    Stok fisik per ukuran
                                </span>
                            </div>

                            <div class="size-category">
                                <div class="size-category-title">Baju</div>

                                <?php if($shirtSizes->isEmpty()): ?>
                                    <div class="form-help">Belum ada ukuran baju yang tersedia untuk kostum ini.</div>
                                <?php else: ?>
                                    <div class="size-list">
                                        <?php $__currentLoopData = $shirtSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $sizeValue = $stockSize->size;
                                                $oldValue = (int) old('baju.' . $sizeValue, 0);
                                                $maxValue = (int) ($availableSizes['baju'][$sizeValue] ?? 0);
                                            ?>

                                            <div class="size-item">
                                                <div>
                                                    <div class="size-name"><?php echo e($sizeValue); ?></div>
                                                    <span class="size-stock">Stok <?php echo e($maxValue); ?> pcs</span>
                                                </div>

                                                <div class="size-control">
                                                    <button
                                                        type="button"
                                                        class="size-button"
                                                        data-size-action="minus"
                                                        data-target="baju-<?php echo e(md5($sizeValue)); ?>"
                                                        aria-label="Kurangi baju ukuran <?php echo e($sizeValue); ?>"
                                                    >−</button>

                                                    <input
                                                        class="size-input size-quantity"
                                                        type="number"
                                                        id="baju-<?php echo e(md5($sizeValue)); ?>"
                                                        name="baju[<?php echo e($sizeValue); ?>]"
                                                        value="<?php echo e(min($oldValue, $maxValue)); ?>"
                                                        min="0"
                                                        max="<?php echo e($maxValue); ?>"
                                                        data-category="baju"
                                                        data-size="<?php echo e($sizeValue); ?>"
                                                        required
                                                    >

                                                    <button
                                                        type="button"
                                                        class="size-button"
                                                        data-size-action="plus"
                                                        data-target="baju-<?php echo e(md5($sizeValue)); ?>"
                                                        aria-label="Tambah baju ukuran <?php echo e($sizeValue); ?>"
                                                    >+</button>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="size-summary" id="shirtSizeSummary">
                                    <span>Total baju</span>
                                    <strong><span id="shirtSizeTotal">0</span> / <span class="required-set-count">1</span> set</strong>
                                </div>
                                <div class="size-error" id="shirtSizeError"></div>
                            </div>

                            <div class="size-category">
                                <div class="size-category-title">Celana</div>

                                <?php if($pantsSizes->isEmpty()): ?>
                                    <div class="form-help">Belum ada ukuran celana yang tersedia untuk kostum ini.</div>
                                <?php else: ?>
                                    <div class="size-list">
                                        <?php $__currentLoopData = $pantsSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $sizeValue = $stockSize->size;
                                                $oldValue = (int) old('celana.' . $sizeValue, 0);
                                                $maxValue = (int) ($availableSizes['celana'][$sizeValue] ?? 0);
                                            ?>

                                            <div class="size-item">
                                                <div>
                                                    <div class="size-name"><?php echo e($sizeValue); ?></div>
                                                    <span class="size-stock">Stok <?php echo e($maxValue); ?> pcs</span>
                                                </div>

                                                <div class="size-control">
                                                    <button
                                                        type="button"
                                                        class="size-button"
                                                        data-size-action="minus"
                                                        data-target="celana-<?php echo e(md5($sizeValue)); ?>"
                                                        aria-label="Kurangi celana ukuran <?php echo e($sizeValue); ?>"
                                                    >−</button>

                                                    <input
                                                        class="size-input size-quantity"
                                                        type="number"
                                                        id="celana-<?php echo e(md5($sizeValue)); ?>"
                                                        name="celana[<?php echo e($sizeValue); ?>]"
                                                        value="<?php echo e(min($oldValue, $maxValue)); ?>"
                                                        min="0"
                                                        max="<?php echo e($maxValue); ?>"
                                                        data-category="celana"
                                                        data-size="<?php echo e($sizeValue); ?>"
                                                        required
                                                    >

                                                    <button
                                                        type="button"
                                                        class="size-button"
                                                        data-size-action="plus"
                                                        data-target="celana-<?php echo e(md5($sizeValue)); ?>"
                                                        aria-label="Tambah celana ukuran <?php echo e($sizeValue); ?>"
                                                    >+</button>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="size-summary" id="pantsSizeSummary">
                                    <span>Total celana</span>
                                    <strong><span id="pantsSizeTotal">0</span> / <span class="required-set-count">1</span> set</strong>
                                </div>
                                <div class="size-error" id="pantsSizeError"></div>
                            </div>
                        </div>

                        <div class="notice">
                            <span class="material-symbols-outlined">
                                info
                            </span>

                            <span>
                                Pilihan ukuran akan disimpan bersama pengajuan. Ketersediaan akan diverifikasi kembali oleh sistem sebelum pengajuan diproses.
                            </span>
                        </div>

                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="rental_date">
                            Tanggal sewa
                            <span class="required">*</span>
                        </label>

                        <div class="selected-date-box">
                            <span class="material-symbols-outlined">calendar_month</span>
                            <div class="rental-date-input-wrap">
                                <input
                                    type="date"
                                    id="rental_date"
                                    name="rental_date"
                                    value="<?php echo e($rentalDate); ?>"
                                    min="<?php echo e(now()->format('Y-m-d')); ?>"
                                    required
                                >
                                <div class="date-change-note">Tanggal bisa diubah langsung di form. Stok akan diperiksa ulang otomatis.</div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>

            
            <div class="submit-area">

                <label class="submit-check">

                    <input
                        type="checkbox"
                        id="agreement"
                        required
                    >

                    <span>
                        Saya memastikan data yang saya masukkan sudah benar
                        dan memahami bahwa pengajuan ini masih menunggu
                        konfirmasi ketersediaan dari Sebajar.id.
                    </span>

                </label>

                <input
                    type="hidden"
                    name="costume_code"
                    value="<?php echo e($costume->code); ?>"
                >

                <button
                    type="submit"
                    class="submit-button"
                    id="submitButton"
                >
                    Kirim Pengajuan Penyewaan

                    <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </button>

                <div class="after-submit">
                    Setelah dikirim, admin Sebajar.id akan memeriksa
                    ketersediaan dan menghubungi kamu.
                </div>

            </div>

        </form>

    </section>

    
    <section class="help-band">

        <div>

            <h2>
                Masih bingung dengan proses penyewaan?
            </h2>

            <p>
                Tidak perlu khawatir. Jika kamu ingin memastikan jumlah,
                ukuran, atau jadwal penyewaan terlebih dahulu, silakan
                hubungi tim Sebajar.id.
            </p>

        </div>

        <a
            href="<?php echo e($whatsappUrl); ?>"
            class="help-button"
        >
            Hubungi Admin
        </a>

    </section>

</main>


<footer class="site-footer">

    <div class="footer-inner">

        <div>

            <img
                src="<?php echo e(asset('images/sebajar-logo.png')); ?>"
                alt="Sebajar.id"
                class="footer-brand-logo"
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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const quantityInput = document.getElementById('quantity');
    const totalCostume = document.getElementById('totalCostume');
    const rentalDate = document.getElementById('rental_date');
    const rentalForm = document.getElementById('rentalForm');

    const availabilityText =
        document.getElementById('availabilityText');

    const availabilityTitle =
        document.getElementById('availabilityTitle');

    const availabilityMessage =
        document.getElementById('availabilityMessage');

    const costumeCode =
        document.querySelector('input[name="costume_code"]')?.value || '';

    const availabilityUrl =
        "<?php echo e(route('penyewaan.availability')); ?>";

    const baseStock = Number(
        quantityInput ? quantityInput.max : 0
    );

    let availableStock = baseStock;

        function closeSuccessNotification() {
            const notification =
                document.getElementById('successNotification');

            if (notification) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-8px)';

                setTimeout(function () {
                    notification.remove();
                }, 200);
            }
        }

    function updateTotal() {

        let quantity = parseInt(
            quantityInput.value,
            10
        );

        const limit = Math.max(
            0,
            Number.isFinite(availableStock)
                ? availableStock
                : baseStock
        );

        if (isNaN(quantity) || quantity < 1) {
            quantity = limit > 0 ? 1 : 0;
        }

        if (quantity > limit) {
            quantity = limit;
        }

        if (limit > 0) {
            quantityInput.value = quantity;
        }

        totalCostume.textContent =
            quantity + ' set';

        updateSizeSummaries();
    }

    function getSizeInputs(category) {
        return Array.from(
            document.querySelectorAll(`.size-quantity[data-category=\"${category}\"]`)
        );
    }

    function getSizeTotal(category) {
        return getSizeInputs(category).reduce(function (total, input) {
            const value = parseInt(input.value, 10);
            return total + (Number.isFinite(value) && value > 0 ? value : 0);
        }, 0);
    }

    function updateSizeSummaries() {
        const quantity = parseInt(quantityInput.value, 10) || 0;
        const shirtTotal = getSizeTotal('baju');
        const pantsTotal = getSizeTotal('celana');

        document.querySelectorAll('.required-set-count').forEach(function (element) {
            element.textContent = quantity;
        });

        document.getElementById('shirtSizeTotal').textContent = shirtTotal;
        document.getElementById('pantsSizeTotal').textContent = pantsTotal;

        updateSizeSummaryState('shirtSizeSummary', 'shirtSizeError', shirtTotal, quantity, 'baju');
        updateSizeSummaryState('pantsSizeSummary', 'pantsSizeError', pantsTotal, quantity, 'celana');
    }

    function updateSizeSummaryState(summaryId, errorId, total, target, category) {
        const summary = document.getElementById(summaryId);
        const error = document.getElementById(errorId);

        if (!summary || !error) {
            return;
        }

        summary.classList.remove('is-valid', 'is-invalid');
        error.classList.remove('visible');
        error.textContent = '';

        if (target <= 0) {
            return;
        }

        if (total === target) {
            summary.classList.add('is-valid');
            return;
        }

        summary.classList.add('is-invalid');
        error.classList.add('visible');
        error.textContent =
            `Total ${category} harus ${target} pcs. Saat ini ${total} pcs.`;
    }

    function validateSizeSelection() {
        const quantity = parseInt(quantityInput.value, 10) || 0;
        const shirtTotal = getSizeTotal('baju');
        const pantsTotal = getSizeTotal('celana');

        if (getSizeInputs('baju').length === 0 || getSizeInputs('celana').length === 0) {
            alert('Ukuran baju atau celana untuk kostum ini belum tersedia.');
            return false;
        }

        if (shirtTotal !== quantity) {
            alert(`Total ukuran baju harus ${quantity} pcs. Saat ini ${shirtTotal} pcs.`);
            return false;
        }

        if (pantsTotal !== quantity) {
            alert(`Total ukuran celana harus ${quantity} pcs. Saat ini ${pantsTotal} pcs.`);
            return false;
        }

        return true;
    }

    document.querySelectorAll('.size-button').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.target);

            if (!input) {
                return;
            }

            let value = parseInt(input.value, 10) || 0;
            const max = parseInt(input.max, 10) || 0;

            if (button.dataset.sizeAction === 'plus') {
                value++;
            } else {
                value--;
            }

            value = Math.max(0, Math.min(max, value));
            input.value = value;
            updateSizeSummaries();
        });
    });

    document.querySelectorAll('.size-quantity').forEach(function (input) {
        input.addEventListener('input', function () {
            let value = parseInt(input.value, 10);
            const max = parseInt(input.max, 10) || 0;

            if (!Number.isFinite(value) || value < 0) {
                value = 0;
            }

            if (value > max) {
                value = max;
            }

            input.value = value;
            updateSizeSummaries();
        });
    });

    async function checkAvailability() {
        const date = rentalDate ? rentalDate.value : '';

        if (!date) {
            availableStock = 0;
            quantityInput.disabled = true;
            quantityInput.max = 0;

            availabilityText.textContent =
                'Pilih tanggal dari halaman koleksi';

            availabilityTitle.textContent =
                'Tanggal sewa belum dipilih';

            availabilityMessage.textContent =
                'Kembali ke halaman koleksi untuk memilih satu tanggal sewa.';

            updateTotal();
            return;
        }

        availabilityText.textContent = 'Memeriksa...';
        availabilityTitle.textContent = 'Mengecek ketersediaan';
        availabilityMessage.textContent =
            'Sedang mengecek stok untuk tanggal yang dipilih.';

        try {
            const params = new URLSearchParams({
                costume_code: costumeCode,
                quantity: String(
                    Math.max(1, parseInt(quantityInput.value, 10) || 1)
                ),
                rental_date: date,
            });

            const response = await fetch(
                availabilityUrl + '?' + params.toString(),
                {
                    headers: {
                        'Accept': 'application/json',
                    },
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || 'Gagal mengecek ketersediaan.'
                );
            }

            availableStock = Number(data.available_stock || 0);
            quantityInput.max = availableStock;

            // Tanggal dapat diubah langsung di form. Saat berubah,
            // batas tiap ukuran juga harus mengikuti stok pada tanggal baru.
            const availableSizes = data.available_sizes || { baju: {}, celana: {} };
            document.querySelectorAll('.size-quantity').forEach(function (input) {
                const category = input.dataset.category || '';
                const size = input.dataset.size || '';
                const max = Number(availableSizes?.[category]?.[size] ?? 0);
                input.max = max;
                input.value = Math.min(Math.max(0, parseInt(input.value, 10) || 0), max);

                const stockLabel = input.closest('.size-item')?.querySelector('.size-stock');
                if (stockLabel) stockLabel.textContent = `Stok ${max} pcs`;
            });

            if (availableStock <= 0) {
                quantityInput.value = 0;
                quantityInput.disabled = true;

                availabilityText.textContent = 'Tidak tersedia';
                availabilityTitle.textContent = 'Kostum sedang disewa';
                availabilityMessage.textContent =
                    data.message ||
                    'Semua stok kostum sedang terkunci oleh penyewaan lain.';
            } else {
                quantityInput.disabled = false;

                let currentQuantity =
                    parseInt(quantityInput.value, 10) || 1;

                currentQuantity = Math.min(
                    Math.max(1, currentQuantity),
                    availableStock
                );

                quantityInput.value = currentQuantity;

                availabilityText.textContent =
                    `Tersedia ${availableStock} set`;

                availabilityTitle.textContent =
                    `${availableStock} set tersedia`;

                availabilityMessage.textContent =
                    'Jumlah ini tersedia untuk tanggal yang kamu pilih.';
            }

            updateTotal();
        } catch (error) {
            quantityInput.disabled = true;
            availableStock = 0;

            availabilityText.textContent = 'Gagal mengecek';
            availabilityTitle.textContent =
                'Ketersediaan belum dapat dicek';

            availabilityMessage.textContent =
                error.message || 'Silakan coba lagi.';
        }
    }

    document
        .querySelectorAll('.quantity-button')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                let value = parseInt(
                    quantityInput.value,
                    10
                ) || 1;

                if (button.dataset.action === 'plus') {
                    value++;
                }

                if (button.dataset.action === 'minus') {
                    value--;
                }

                const limit = availableStock;

                value = Math.max(
                    1,
                    Math.min(limit, value)
                );

                quantityInput.value = value;

                updateTotal();

            });

        });

    quantityInput.addEventListener(
        'input',
        updateTotal
    );

    const today =
        new Date().toISOString().split('T')[0];

    if (rentalDate) {
        rentalDate.min = today;

        rentalDate.addEventListener(
            'change',
            checkAvailability
        );
    }

    checkAvailability();

    if (rentalForm) {

        rentalForm.addEventListener(
            'submit',
            function (event) {
                const quantity =
                    parseInt(quantityInput.value, 10);

                if (
                    isNaN(quantity) ||
                    quantity < 1
                ) {
                    event.preventDefault();

                    alert(
                        'Silakan masukkan jumlah set minimal 1.'
                    );

                    return;
                }

                if (!rentalDate || !rentalDate.value) {
                    event.preventDefault();
                    alert('Silakan pilih tanggal sewa terlebih dahulu.');
                    return;
                }

                if (!validateSizeSelection()) {
                    event.preventDefault();
                    return;
                }

                if (availableStock <= 0) {
                    event.preventDefault();

                    alert(
                        'Kostum sedang tidak tersedia.'
                    );

                    return;
                }

                if (quantity > availableStock) {
                    event.preventDefault();

                    alert(
                        `Jumlah set melebihi stok tersedia. Maksimal ${availableStock} set.`
                    );

                    return;
                }
            }
        );

    }

    updateTotal();

});
</script>

</body>
</html>
<?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/penyewaan.blade.php ENDPATH**/ ?>