<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — Sebajar.id</title>
    <link rel="stylesheet" href="{{ asset('css/sebajar-home.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,500,0,0" rel="stylesheet">
    <style>
        .profile-page{min-height:calc(100vh - 76px);background:#fff;padding:52px 20px 80px}.profile-wrap{max-width:980px;margin:auto}.profile-head{margin-bottom:24px}.profile-eyebrow{color:#7b1e2b;font-size:11px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}.profile-head h1{margin:7px 0 8px;font:800 clamp(28px,4vw,42px)/1.1 Montserrat,sans-serif;color:#332e2a;letter-spacing:-.04em}.profile-head p{margin:0;color:#7f766e;font-size:14px;line-height:1.7}.profile-grid{display:grid;grid-template-columns:290px minmax(0,1fr);gap:20px}.profile-card,.form-card{background:#fff;border:1px solid #e7e0d6;border-radius:14px;box-shadow:none}.profile-card{padding:25px}.profile-avatar{width:62px;height:62px;border-radius:50%;display:grid;place-items:center;background:#f1ece5;color:#5f5953;font-size:22px;font-weight:800}.profile-card h2{margin:18px 0 4px;color:#332e2a;font-size:20px}.profile-role{color:#8c847b;font-size:12px;text-transform:capitalize}.profile-stats{margin-top:24px;padding-top:20px;border-top:1px solid #eee8e0;display:grid;gap:11px}.profile-stat{display:flex;align-items:center;justify-content:space-between;color:#655d56;font-size:12px}.profile-stat strong{color:#332e2a}.form-card{padding:28px}.form-card h2{margin:0;color:#332e2a;font:700 18px Montserrat,sans-serif}.form-card>p{margin:6px 0 24px;color:#8c847b;font-size:12px}.field{margin-bottom:17px}.field label{display:block;margin-bottom:7px;color:#4b4540;font-size:11px;font-weight:800}.field input{width:100%;min-height:44px;border:1px solid #dcd3c9;border-radius:10px;padding:0 13px;outline:none;font:inherit;font-size:13px;color:#332e2a;background:#fff}.field input:focus{border-color:#7b1e2b;box-shadow:0 0 0 3px rgba(123,30,43,.08)}.password-box{margin-top:24px;padding:18px;border-radius:12px;background:#fbfaf8;border:1px solid #eee8e0}.password-box h3{margin:0;color:#332e2a;font-size:13px}.password-box p{margin:4px 0 15px;color:#8c847b;font-size:11px}.password-grid{display:grid;grid-template-columns:1fr 1fr;gap:13px}.actions{display:flex;justify-content:flex-end;gap:10px;margin-top:23px}.profile-btn{border:1px solid transparent;border-radius:999px;padding:10px 16px;font-size:12px;font-weight:800;cursor:pointer;text-decoration:none}.profile-btn.secondary{background:#fff;border-color:#d8d2ce;color:#5f5953}.profile-btn.primary{background:#7b1e2b;color:#fff}.profile-alert{margin-bottom:17px;border-radius:11px;padding:12px 14px;font-size:12px}.profile-alert.success{border:1px solid #d9e9d8;background:#f3faf2;color:#356333}.profile-errors{border:1px solid #f0cfd1;background:#fff5f5;color:#96333c}.profile-errors ul{margin:0;padding-left:17px}@media(max-width:760px){.profile-grid{grid-template-columns:1fr}.password-grid{grid-template-columns:1fr}.profile-card{display:flex;align-items:center;gap:17px}.profile-card .profile-stats{margin:0 0 0 auto;padding:0;border:0;min-width:130px}.profile-card h2{margin:0 0 3px}.profile-card .profile-avatar{width:56px;height:56px;flex:0 0 56px;border-radius:50%}}@media(max-width:520px){.profile-page{padding:34px 13px 60px}.profile-card{display:block}.profile-card .profile-stats{margin-top:20px;padding-top:17px;border-top:1px solid #eee8e0}.form-card{padding:20px}.actions{flex-direction:column}.profile-btn{width:100%;text-align:center}}
    </style>
</head>
<body>
@include('partials.user-header')
<main class="profile-page">
    <div class="profile-wrap">
        <header class="profile-head">
            <div class="profile-eyebrow">Akun Sebajar.id</div>
            <h1>Profil Saya</h1>
            <p>Kelola nama akun dan password tanpa perlu meninggalkan halaman ini.</p>
        </header>

        <div class="profile-grid">
            <aside class="profile-card">
                <div class="profile-avatar"><span class="material-symbols-outlined" aria-hidden="true">person</span></div>
                <div>
                    <h2>{{ $user->name }}</h2>
                    <div class="profile-role">{{ $user->role }}</div>
                </div>
                <div class="profile-stats">
                    <div class="profile-stat"><span>Total pengajuan</span><strong>{{ $orderCount }}</strong></div>
                    <div class="profile-stat"><span>Menunggu</span><strong>{{ $pendingCount }}</strong></div>
                </div>
            </aside>

            <section class="form-card">
                <h2>Informasi akun</h2>
                <p>Perubahan akan langsung tersimpan pada akun yang sedang digunakan.</p>

                @if(session('success'))
                    <div class="profile-alert success">✓ {{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="profile-alert profile-errors"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif

                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="field"><label for="name">Nama pengguna</label><input id="name" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" required></div>
                    <div class="password-box">
                        <h3>Ganti password <span style="font-weight:400;color:#9b9187">(opsional)</span></h3>
                        <p>Kosongkan jika kamu tidak ingin mengganti password.</p>
                        <div class="field"><label for="current_password">Password saat ini</label><input id="current_password" name="current_password" type="password" autocomplete="current-password"></div>
                        <div class="password-grid">
                            <div class="field" style="margin-bottom:0"><label for="password">Password baru</label><input id="password" name="password" type="password" autocomplete="new-password"></div>
                            <div class="field" style="margin-bottom:0"><label for="password_confirmation">Konfirmasi password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"></div>
                        </div>
                    </div>
                    <div class="actions"><a href="{{ route('pesanan') }}" class="profile-btn secondary">Pesanan Saya</a><button type="submit" class="profile-btn primary">Simpan Perubahan</button></div>
                </form>
            </section>
        </div>
    </div>
</main>
@include('partials.public-footer')
</body>
</html>
