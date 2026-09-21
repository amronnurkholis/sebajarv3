<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — Sebajar.id</title>
    <link rel="stylesheet" href="{{ asset('css/sebajar-home.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,500,0,0" rel="stylesheet">
    <style>
        .orders-page{min-height:100vh;background:#fff;padding:104px 0 60px}.orders-wrap{max-width:1000px;margin:auto;padding:0 20px}.orders-head{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:28px}.orders-head h1{font-family:Montserrat,sans-serif;color:#332e2a;font-size:clamp(25px,4vw,38px);margin:0 0 7px}.orders-head p{color:#8c847b;margin:0;font-size:14px}.orders-actions{display:flex;gap:10px;align-items:center}.order-card{background:#fff;border:1px solid #e7e0d6;border-radius:14px;padding:20px;margin-bottom:14px;box-shadow:none}.order-top{display:flex;justify-content:space-between;gap:16px}.order-code{font-size:11px;font-weight:700;letter-spacing:.08em;color:#9b9187;text-transform:uppercase}.order-title{font-size:17px;font-weight:700;color:#332e2a;margin:5px 0}.order-meta{font-size:13px;color:#655d56}.order-status{white-space:nowrap;border-radius:999px;padding:7px 11px;font-size:11px;font-weight:700;height:max-content}.pending{background:#fff4d9;color:#956a16}.approved{background:#eaf5ea;color:#356333}.completed{background:#e9eef8;color:#3f557d}.rejected{background:#fbeaea;color:#96333c}.order-details{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;border-top:1px solid #eee8e0;margin-top:16px;padding-top:16px}.label{font-size:10px;color:#a39a90;text-transform:uppercase;letter-spacing:.08em}.value{margin-top:4px;font-size:13px;color:#332e2a}.empty-order{text-align:center;background:#fff;border:0;border-radius:0;padding:54px 20px}.empty-order .material-symbols-outlined{font-size:32px;color:#5f5953}.empty-order h2{margin:12px 0 5px;color:#332e2a;font-size:19px}.empty-order p{color:#8c847b;font-size:13px;margin:0}.back-link{color:#5f5953;font-size:13px;font-weight:700}.back-link:hover{color:#7b1e2b}@media(max-width:620px){.orders-page{padding-top:86px}.orders-head{align-items:stretch;flex-direction:column}.orders-actions{width:100%}.orders-actions a{flex:1;text-align:center}.order-top{flex-direction:column}.order-status{width:max-content}.order-details{grid-template-columns:1fr}}
    .order-main-row{display:flex;gap:18px}.order-image{width:120px;height:100px;flex:0 0 120px;border-radius:12px;background:#f1ece5;overflow:hidden;display:grid;place-items:center;color:#7b1e2b}.order-image img{width:100%;height:100%;object-fit:cover}.order-content{min-width:0;flex:1}.order-actions-row{margin-top:15px}.order-contact{display:inline-flex;align-items:center;color:#7b1e2b;font-size:12px;font-weight:700;text-decoration:none}.order-contact:hover{text-decoration:underline}@media(max-width:620px){.order-main-row{flex-direction:column}.order-image{width:100%;height:180px;flex-basis:auto}.order-content{width:100%}}</style>
</head>
<body>
@include('partials.user-header')
<main class="orders-page"><div class="orders-wrap">
    <div class="orders-head">
        <div><a class="back-link" href="{{ url('/') }}">← Kembali ke beranda</a><h1>Pesanan Saya</h1><p>Semua pengajuan penyewaan yang terkait dengan akunmu.</p></div>
        <div class="orders-actions"><a href="{{ url('/koleksi') }}" class="btn btn-primary">Sewa Kostum</a></div>
    </div>
    @forelse($rentals as $rental)
        @php $statusClass = in_array($rental->status, ['pending','approved','completed','rejected'], true) ? $rental->status : 'pending'; @endphp
        <article class="order-card">
            @php
                $orderImage = $rental->costume?->image_url ?: $rental->costume?->images?->first()?->image_url;
            @endphp
            <div class="order-main-row">
                <div class="order-image">
                    @if($orderImage)
                        <img src="{{ $orderImage }}" alt="{{ $rental->costume_code }}">
                    @else
                        <span class="material-symbols-outlined">checkroom</span>
                    @endif
                </div>
                <div class="order-content">
                    <div class="order-top"><div><div class="order-code">{{ $rental->costume_code }}</div><h2 class="order-title">{{ $rental->team_name }}</h2><div class="order-meta">{{ $rental->quantity }} set · {{ optional($rental->rental_start)->format('d M Y') }}</div></div><span class="order-status {{ $statusClass }}">{{ match($rental->status){'pending'=>'Menunggu Persetujuan','approved'=>'Disetujui Admin','completed'=>'Selesai','rejected'=>'Ditolak',default=>ucfirst($rental->status)} }}</span></div>
                    <div class="order-details"><div><div class="label">Nama penyewa</div><div class="value">{{ $rental->customer_name }}</div></div><div><div class="label">Ukuran dipilih</div><div class="value">{{ $rental->sizes->map(fn($s) => ucfirst($s->category).' '.$s->size.' ('.$s->quantity.')')->join(', ') ?: '-' }}</div></div></div>
                    <div class="order-actions-row"><a href="{{ config('sebajar.admin_whatsapp') ? 'https://wa.me/' . config('sebajar.admin_whatsapp') . '?text=' . rawurlencode('Halo Admin Sebajar, saya ingin menanyakan pesanan ' . $rental->costume_code . ' milik ' . $rental->customer_name . '.') : '#' }}" target="_blank" rel="noopener" class="order-contact"><span class="material-symbols-outlined" aria-hidden="true">chat</span> Hubungi Admin</a></div>
                </div>
            </div>
        </article>
    @empty
        <div class="empty-order"><span class="material-symbols-outlined">receipt_long</span><h2>Belum ada pesanan</h2><p>Pengajuan penyewaanmu akan muncul di sini setelah dikirim.</p><a href="{{ url('/koleksi') }}" class="text-link" style="margin-top:18px">Lihat Koleksi <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a></div>
    @endforelse
    @if($rentals->hasPages())<div style="margin-top:20px">{{ $rentals->links() }}</div>@endif
</div></main>
@include('partials.public-footer')
</body>
</html>
