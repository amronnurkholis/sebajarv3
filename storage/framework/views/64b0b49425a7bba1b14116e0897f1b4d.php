<?php
    $adminWhatsapp = preg_replace('/\D+/', '', (string) config('sebajar.admin_whatsapp'));
    $whatsappUrl = $adminWhatsapp ? 'https://wa.me/' . $adminWhatsapp . '?text=' . rawurlencode('Halo Admin Sebajar, saya ingin bertanya mengenai penyewaan kostum.') : '#';
    $isAuthenticated = auth()->check();
    $orderCount = $isAuthenticated ? auth()->user()->rentals()->count() : 0;
    $pendingOrderCount = $isAuthenticated ? auth()->user()->rentals()->where('status', 'pending')->count() : 0;
    $rentalStatus = $rentalStatus ?? app(\App\Services\RentalScheduleService::class)->status();
    $isHome = request()->routeIs('home') || request()->is('/');
?>

<style>
.sebajar-user-header{position:relative;z-index:9000;background:#fff;border-bottom:1px solid #e7e0d6;box-shadow:0 2px 12px rgba(44,41,38,.04)}
.rental-countdown-banner{position:relative;z-index:8999;display:flex;align-items:center;justify-content:center;gap:12px;min-height:48px;padding:8px 20px;color:#fff;background:#7b1e2b;font-size:12px}.rental-countdown-banner .material-symbols-outlined{font-size:19px}.rental-countdown-banner strong{font-weight:800}.rental-countdown-value{padding:5px 11px;border-radius:8px;background:rgba(0,0,0,.2);font-size:16px;font-weight:800;letter-spacing:.07em;font-variant-numeric:tabular-nums}
.rental-countdown-banner{position:relative;z-index:8999;display:flex;align-items:center;justify-content:center;gap:12px;min-height:48px;padding:8px 20px;color:#fff;background:#7b1e2b;font-size:12px}.rental-countdown-banner .material-symbols-outlined{font-size:19px}.rental-countdown-banner strong{font-weight:800}.rental-countdown-value{padding:5px 11px;border-radius:8px;background:rgba(0,0,0,.2);font-size:16px;font-weight:800;letter-spacing:.07em;font-variant-numeric:tabular-nums}@media(max-width:560px){.rental-countdown-banner{justify-content:flex-start;gap:8px;padding:9px 14px;font-size:11px}.rental-countdown-value{margin-left:auto;font-size:14px;padding:5px 8px}}
.btn,.rent-link,.date-apply-button,.submit-button,.help-button,.profile-btn{min-height:46px!important;border-radius:11px!important;transition:transform .18s ease,box-shadow .18s ease,background .18s ease,border-color .18s ease!important}.btn:hover,.rent-link:hover,.date-apply-button:hover,.submit-button:hover,.help-button:hover,.profile-btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(44,41,38,.14)}.btn:active,.rent-link:active,.date-apply-button:active,.submit-button:active,.help-button:active,.profile-btn:active{transform:translateY(0);box-shadow:none}.btn:focus-visible,.rent-link:focus-visible,.date-apply-button:focus-visible,.submit-button:focus-visible,.help-button:focus-visible,.profile-btn:focus-visible{outline:3px solid rgba(123,30,43,.35);outline-offset:3px}
.sebajar-user-nav{max-width:1180px;margin:0 auto;min-height:76px;padding:0 20px;display:flex;align-items:center;gap:22px}.sebajar-user-logo img{height:42px;width:auto;display:block}.sebajar-user-links{display:flex;align-items:center;gap:4px;flex:1}.sebajar-user-links a{color:#5f5953;text-decoration:none;font-size:13px;font-weight:600;padding:10px 11px;border-radius:9px;white-space:nowrap}.sebajar-user-links a:hover,.sebajar-user-links a.active{color:#7b1e2b;background:#f8f1ec}.sebajar-user-actions{display:flex;align-items:center;gap:9px;margin-left:auto}.sebajar-user-actions .user-order{display:inline-flex;align-items:center;gap:5px;text-decoration:none;color:#5f5953;font-size:13px;font-weight:700;padding:9px 10px;border-radius:9px}.sebajar-user-actions .user-order:hover{background:#f8f1ec;color:#7b1e2b}.sebajar-badge{display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;padding:0 5px;border-radius:999px;background:#7b1e2b;color:#fff;font-size:10px}.sebajar-profile{position:relative}.sebajar-profile-trigger{border:0;background:transparent;cursor:pointer;display:flex;align-items:center;gap:9px;padding:5px;border-radius:12px}.sebajar-profile-trigger:hover{background:#f8f1ec}.sebajar-avatar{width:39px;height:39px;border-radius:50%;display:grid;place-items:center;background:#7b1e2b;color:#fff;font-size:13px;font-weight:800}.sebajar-greeting{text-align:left}.sebajar-greeting small{display:block;font-size:10px;color:#9b9187}.sebajar-greeting strong{display:block;font-size:12px;color:#332e2a}.sebajar-profile-menu{position:absolute;right:0;top:52px;width:220px;background:#fff;border:1px solid #e7e0d6;border-radius:14px;padding:8px;box-shadow:0 18px 40px rgba(44,41,38,.14);display:none}.sebajar-profile-menu.open{display:block;animation:profileIn .15s ease-out}.sebajar-profile-info{padding:10px 11px 12px;border-bottom:1px solid #eee8e0;margin-bottom:5px}.sebajar-profile-info strong{display:block;color:#332e2a;font-size:13px}.sebajar-profile-info span{display:block;color:#8c847b;font-size:11px;margin-top:2px;text-transform:capitalize}.sebajar-profile-menu a,.sebajar-profile-menu button{width:100%;display:flex;align-items:center;gap:9px;padding:10px 11px;border:0;background:transparent;border-radius:9px;color:#5f5953;text-decoration:none;font:inherit;font-size:12px;font-weight:600;cursor:pointer;text-align:left}.sebajar-profile-menu a:hover,.sebajar-profile-menu button:hover{background:#f8f1ec;color:#7b1e2b}.sebajar-profile-menu form{margin:0}.sebajar-mobile-toggle{display:none;border:0;background:#f8f1ec;color:#7b1e2b;width:42px;height:42px;border-radius:10px;cursor:pointer}.sebajar-mobile-panel{display:none}
@keyframes profileIn{from{opacity:0;transform:translateY(-5px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:900px){.sebajar-user-nav{gap:10px}.sebajar-user-links{display:none}.sebajar-mobile-toggle{display:grid;place-items:center;order:2}.sebajar-user-actions{order:3}.sebajar-user-logo{order:1}.sebajar-greeting{display:none}.sebajar-user-actions .user-order span:not(.material-symbols-outlined):not(.sebajar-badge){display:none}.sebajar-mobile-panel{position:absolute;left:12px;right:12px;top:70px;background:#fff;border:1px solid #e7e0d6;border-radius:14px;padding:8px;box-shadow:0 18px 40px rgba(44,41,38,.14);display:none}.sebajar-mobile-panel.open{display:block}.sebajar-mobile-panel a,.sebajar-mobile-panel button{display:flex;align-items:center;gap:8px;padding:11px 12px;color:#5f5953;text-decoration:none;font-size:13px;font-weight:600;border-radius:9px}.sebajar-mobile-panel a:hover,.sebajar-mobile-panel button:hover{background:#f8f1ec;color:#7b1e2b}.sebajar-mobile-panel form{margin:0}.sebajar-mobile-panel button{width:100%;border:0;background:transparent;cursor:pointer;text-align:left}.sebajar-mobile-divider{height:1px;background:#eee8e0;margin:6px 4px}.sebajar-mobile-badge{margin-left:auto;min-width:18px;padding:2px 6px;border-radius:999px;background:#7b1e2b;color:#fff;font-size:10px;text-align:center}}
@media(max-width:520px){.sebajar-user-nav{min-height:62px;padding:0 14px}.sebajar-user-logo img{height:30px}.sebajar-profile-menu{right:-4px}.sebajar-user-actions{gap:2px}.sebajar-avatar{width:36px;height:36px;font-size:12px}.sebajar-mobile-toggle{width:38px;height:38px;border-radius:11px}.sebajar-mobile-toggle .material-symbols-outlined{font-size:21px}.sebajar-user-actions .user-order{padding:7px}.sebajar-user-actions .user-order .material-symbols-outlined{font-size:20px}.rental-countdown-banner{justify-content:flex-start;gap:8px;padding:9px 14px;font-size:11px}.rental-countdown-value{margin-left:auto;font-size:14px;padding:5px 8px}}
.sebajar-user-header--home{position:absolute;top:0;left:0;right:0;background:linear-gradient(180deg,rgba(5,5,5,.65),transparent);border:0;box-shadow:none;transition:background .25s ease,backdrop-filter .25s ease}.sebajar-user-header--home.is-scrolled{position:fixed;background:rgba(18,15,15,.88);backdrop-filter:blur(12px);box-shadow:0 5px 18px rgba(0,0,0,.16)}.sebajar-user-header--home .sebajar-user-logo img{filter:brightness(0) invert(1)}.sebajar-user-header--home .sebajar-user-links a,.sebajar-user-header--home .user-order,.sebajar-user-header--home .sebajar-greeting strong{color:#fff}.sebajar-user-header--home .sebajar-greeting small{color:rgba(255,255,255,.7)}.sebajar-user-header--home .sebajar-user-links a:hover,.sebajar-user-header--home .sebajar-user-links a.active{color:#fff;background:rgba(135,19,45,.78)}.sebajar-user-header--home .sebajar-user-links a.active{padding-inline:16px}.sebajar-user-header--home .sebajar-user-actions .user-order:hover,.sebajar-user-header--home .sebajar-profile-trigger:hover{background:rgba(255,255,255,.12);color:#fff}.sebajar-user-header--home .sebajar-profile-menu{color:#5f5953}.sebajar-user-header--home .sebajar-mobile-toggle{color:#fff;background:rgba(255,255,255,.12)}.sebajar-user-header--home .sebajar-avatar{width:36px;height:36px;font-size:12px}.sebajar-user-header--home .sebajar-greeting small{font-size:11px}.sebajar-user-header--home .sebajar-greeting strong{font-size:13px}.sebajar-user-header--home .user-order{gap:8px;font-size:14px}.sebajar-user-header--home .user-order .material-symbols-outlined{font-size:21px}
@media(max-width:900px){.sebajar-user-header--home .sebajar-mobile-panel{top:70px;background:rgba(26,22,22,.97);border-color:rgba(255,255,255,.14)}.sebajar-user-header--home .sebajar-mobile-panel a,.sebajar-user-header--home .sebajar-mobile-panel button{color:#fff}.sebajar-user-header--home .sebajar-mobile-panel a:hover,.sebajar-user-header--home .sebajar-mobile-panel button:hover{background:rgba(255,255,255,.1);color:#fff}}

/* Shared navigation and action polish — preserves existing structure and colors. */
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;line-height:1;vertical-align:middle}
.sebajar-user-nav{min-height:72px;gap:18px}.sebajar-user-links{gap:2px}.sebajar-user-links a{position:relative;min-height:40px;display:inline-flex;align-items:center;transition:color .16s ease,background .16s ease}.sebajar-user-links a::after{content:"";position:absolute;right:11px;bottom:6px;left:11px;height:2px;border-radius:999px;background:currentColor;opacity:0;transform:scaleX(.55);transition:opacity .16s ease,transform .16s ease}.sebajar-user-links a:hover::after,.sebajar-user-links a.active::after{opacity:1;transform:scaleX(1)}.sebajar-user-actions .user-order{min-height:40px;border:1px solid transparent;transition:color .16s ease,background .16s ease,border-color .16s ease}.sebajar-profile-trigger{min-height:42px;transition:background .16s ease}.sebajar-mobile-toggle{transition:background .16s ease,transform .16s ease}.sebajar-mobile-toggle:active{transform:scale(.96)}.sebajar-mobile-panel a,.sebajar-mobile-panel button{min-height:42px;transition:color .16s ease,background .16s ease}.sebajar-user-header a:focus-visible,.sebajar-user-header button:focus-visible,.btn:focus-visible,.date-apply-button:focus-visible,.rent-link:focus-visible,.detail-link:focus-visible,.submit-button:focus-visible,.help-button:focus-visible,.profile-btn:focus-visible,.quantity-button:focus-visible,.size-button:focus-visible{outline:3px solid rgba(123,30,43,.32);outline-offset:3px}.btn,.date-apply-button,.rent-link,.detail-link,.submit-button,.help-button,.profile-btn{font-family:inherit;transition:transform .16s ease,box-shadow .16s ease,background .16s ease,border-color .16s ease,color .16s ease}.date-apply-button,.rent-link,.detail-link,.submit-button,.help-button,.profile-btn{display:inline-flex;align-items:center;justify-content:center;text-decoration:none}.date-apply-button:active,.rent-link:active,.submit-button:active,.help-button:active,.profile-btn:active{transform:translateY(0)}.date-apply-button:disabled,.submit-button:disabled,.rent-link.disabled{box-shadow:none;cursor:not-allowed}.quantity-button,.size-button{transition:color .16s ease,border-color .16s ease,background .16s ease,transform .16s ease}.quantity-button:active,.size-button:active{transform:scale(.94)}
@media(max-width:520px){.sebajar-user-nav{min-height:62px;gap:8px}.sebajar-user-links a::after{display:none}.sebajar-user-actions .user-order{min-height:38px}.sebajar-mobile-panel a,.sebajar-mobile-panel button{min-height:44px}}
/* Compact status and account treatment shared by all public pages. */
.rental-countdown-banner{min-height:42px;padding:6px 16px;gap:9px;background:#681924;font-size:11px}.rental-countdown-banner .material-symbols-outlined{font-size:17px}.rental-countdown-value{padding:4px 8px;border-radius:6px;background:rgba(0,0,0,.16);font-size:14px}.sebajar-profile-trigger{gap:7px}.sebajar-avatar{width:30px;height:30px;background:transparent;color:#5f5953;border-radius:0}.sebajar-avatar .material-symbols-outlined{font-size:22px}.sebajar-user-header--home .sebajar-avatar{width:30px;height:30px;color:#fff;background:transparent}.sebajar-user-header--home .sebajar-profile-trigger{padding:6px}.sebajar-user-actions .user-order .material-symbols-outlined{font-size:19px}@media(max-width:520px){.sebajar-avatar,.sebajar-user-header--home .sebajar-avatar{width:28px;height:28px}.sebajar-avatar .material-symbols-outlined{font-size:21px}.rental-countdown-banner{min-height:40px;padding:6px 13px}.rental-countdown-value{font-size:13px}}
/* Button refinement inspired by Uiverse's restrained hover/press feedback. */
.btn,.date-apply-button,.rent-link,.submit-button,.help-button,.profile-btn{min-height:42px!important;border-radius:999px!important;font-weight:600!important;transition:transform .16s ease-out,box-shadow .16s ease-out,background-color .16s ease-out,border-color .16s ease-out,color .16s ease-out!important}.btn:hover,.date-apply-button:hover,.rent-link:hover,.submit-button:hover,.help-button:hover,.profile-btn:hover{transform:translateY(-1px);box-shadow:0 3px 9px rgba(44,41,38,.10)}.btn:active,.date-apply-button:active,.rent-link:active,.submit-button:active,.help-button:active,.profile-btn:active{transform:translateY(0) scale(.985);box-shadow:none}.btn .material-symbols-outlined,.date-apply-button .material-symbols-outlined,.rent-link .material-symbols-outlined,.submit-button .material-symbols-outlined,.help-button .material-symbols-outlined,.profile-btn .material-symbols-outlined{transition:transform .16s ease-out}.btn:hover .material-symbols-outlined,.date-apply-button:hover .material-symbols-outlined,.rent-link:hover .material-symbols-outlined,.submit-button:hover .material-symbols-outlined,.help-button:hover .material-symbols-outlined,.profile-btn:hover .material-symbols-outlined{transform:translateX(2px)}@media(prefers-reduced-motion:reduce){.btn,.date-apply-button,.rent-link,.submit-button,.help-button,.profile-btn,.btn .material-symbols-outlined,.date-apply-button .material-symbols-outlined,.rent-link .material-symbols-outlined,.submit-button .material-symbols-outlined,.help-button .material-symbols-outlined,.profile-btn .material-symbols-outlined{transition:none!important}}
</style>

<header class="sebajar-user-header <?php echo e($isHome ? 'sebajar-user-header--home' : ''); ?>" data-user-header>
    <div class="sebajar-user-nav">
        <a class="sebajar-user-logo" href="<?php echo e(url('/')); ?>" aria-label="Sebajar.id"><img src="<?php echo e(asset('images/sebajar-logo.png')); ?>" alt="Sebajar.id"></a>

        <nav class="sebajar-user-links" aria-label="Navigasi utama">
            <a class="<?php echo e(request()->routeIs('home') || request()->is('/') ? 'active' : ''); ?>" href="<?php echo e(url('/')); ?>">Beranda</a>
            <a class="<?php echo e(request()->routeIs('koleksi*') ? 'active' : ''); ?>" href="<?php echo e(route('koleksi')); ?>">Koleksi</a>
            <a href="<?php echo e(url('/#cara-sewa')); ?>">Cara Sewa</a>
            <a href="<?php echo e(url('/#tentang')); ?>">Tentang Kami</a>
            <a href="<?php echo e($whatsappUrl); ?>" target="_blank" rel="noopener">Hubungi Admin</a>
        </nav>

        <div class="sebajar-user-actions">
            <?php if($isAuthenticated): ?>
            <a class="user-order" href="<?php echo e(route('pesanan')); ?>" aria-label="Pesanan Saya">
                <span class="material-symbols-outlined">shopping_bag</span><span>Pesanan</span>
                <?php if($orderCount > 0): ?><span class="sebajar-badge"><?php echo e($pendingOrderCount > 0 ? $pendingOrderCount : $orderCount); ?></span><?php endif; ?>
            </a>

            <div class="sebajar-profile">
                <button type="button" class="sebajar-profile-trigger" data-profile-toggle aria-expanded="false" aria-haspopup="true">
                    <div class="sebajar-avatar"><span class="material-symbols-outlined" aria-hidden="true">person</span></div>
                    <div class="sebajar-greeting"><small>Hi,</small><strong><?php echo e(auth()->user()->name); ?></strong></div>
                </button>
                <div class="sebajar-profile-menu" data-profile-menu>
                    <div class="sebajar-profile-info"><strong><?php echo e(auth()->user()->name); ?></strong><span><?php echo e(auth()->user()->role); ?></span></div>
                    <a href="<?php echo e(route('profil')); ?>"><span class="material-symbols-outlined">person</span>Profil</a>
                    <a href="<?php echo e(route('pesanan')); ?>"><span class="material-symbols-outlined">shopping_bag</span>Pesanan Saya</a>
                    <a href="<?php echo e($whatsappUrl); ?>" target="_blank" rel="noopener"><span class="material-symbols-outlined">chat</span>Hubungi Admin</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit"><span class="material-symbols-outlined">logout</span>Keluar</button></form>
                </div>
            </div>
            <?php else: ?>
                <a class="user-order" href="<?php echo e(route('login')); ?>">Masuk</a>
                <a class="user-order" href="<?php echo e(route('register')); ?>">Daftar</a>
            <?php endif; ?>

            <button type="button" class="sebajar-mobile-toggle" data-mobile-toggle aria-expanded="false" aria-label="Buka menu"><span class="material-symbols-outlined">menu</span></button>
        </div>
    </div>
    <div class="sebajar-mobile-panel" data-mobile-panel>
        <a href="<?php echo e(url('/')); ?>">Beranda</a>
        <a href="<?php echo e(route('koleksi')); ?>">Koleksi</a>
        <a href="<?php echo e(url('/#cara-sewa')); ?>">Cara Sewa</a>
        <a href="<?php echo e(url('/#tentang')); ?>">Tentang Kami</a>
        <?php if($isAuthenticated): ?>
            <div class="sebajar-mobile-divider"></div>
            <a href="<?php echo e(route('profil')); ?>"><span class="material-symbols-outlined">person</span> Profil Saya</a>
            <a href="<?php echo e(route('pesanan')); ?>"><span class="material-symbols-outlined">shopping_bag</span> Pesanan Saya <?php if($pendingOrderCount > 0): ?><span class="sebajar-mobile-badge"><?php echo e($pendingOrderCount); ?></span><?php endif; ?></a>
            <a href="<?php echo e($whatsappUrl); ?>" target="_blank" rel="noopener"><span class="material-symbols-outlined">chat</span> Hubungi Admin</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit"><span class="material-symbols-outlined">logout</span> Keluar</button></form>
        <?php else: ?>
            <div class="sebajar-mobile-divider"></div>
            <a href="<?php echo e(route('login')); ?>">Masuk</a>
            <a href="<?php echo e(route('register')); ?>">Daftar</a>
            <a href="<?php echo e($whatsappUrl); ?>" target="_blank" rel="noopener"><span class="material-symbols-outlined">chat</span> Hubungi Admin</a>
        <?php endif; ?>
    </div>
</header>

<script>
(() => {
 const profileBtn=document.querySelector('[data-profile-toggle]'), profileMenu=document.querySelector('[data-profile-menu]');
 if(profileBtn&&profileMenu){profileBtn.addEventListener('click',e=>{e.stopPropagation(); const open=profileMenu.classList.toggle('open'); profileBtn.setAttribute('aria-expanded',open)}); document.addEventListener('click',e=>{if(!profileMenu.contains(e.target)&&!profileBtn.contains(e.target)){profileMenu.classList.remove('open');profileBtn.setAttribute('aria-expanded','false')}})}
 const mobileBtn=document.querySelector('[data-mobile-toggle]'), mobilePanel=document.querySelector('[data-mobile-panel]');
 if(mobileBtn&&mobilePanel){const closeMobileMenu=()=>{mobilePanel.classList.remove('open');mobileBtn.setAttribute('aria-expanded','false');mobileBtn.querySelector('span').textContent='menu'};mobileBtn.addEventListener('click',()=>{const open=mobilePanel.classList.toggle('open');mobileBtn.setAttribute('aria-expanded',String(open));mobileBtn.querySelector('span').textContent=open?'close':'menu'});mobilePanel.querySelectorAll('a').forEach(link=>link.addEventListener('click',closeMobileMenu));document.addEventListener('keydown',event=>{if(event.key==='Escape')closeMobileMenu()})}
 const header=document.querySelector('[data-user-header]');
 if(header?.classList.contains('sebajar-user-header--home')){const updateHeader=()=>header.classList.toggle('is-scrolled',window.scrollY>24);updateHeader();window.addEventListener('scroll',updateHeader,{passive:true})}
})();

const initRentalCountdowns = () => document.querySelectorAll('[data-rental-status]').forEach((banner) => {
 const target = new Date(banner.dataset.nextChange).getTime();
 if (!target) return;
 const update = () => { const left = Math.max(0, target - Date.now()), total = Math.floor(left / 1000), h = String(Math.floor(total / 3600)).padStart(2,'0'), m = String(Math.floor((total % 3600) / 60)).padStart(2,'0'), s = String(total % 60).padStart(2,'0'); const output = banner.querySelector('[data-countdown]'), hours = banner.querySelector('[data-countdown-hours]'), minutes = banner.querySelector('[data-countdown-minutes]'), seconds = banner.querySelector('[data-countdown-seconds]'); if (output) output.textContent = `${h}:${m}:${s}`; if (hours) hours.textContent = h; if (minutes) minutes.textContent = m; if (seconds) seconds.textContent = s; if (!left) window.location.reload(); };
 update(); setInterval(update, 1000);
});

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initRentalCountdowns); else initRentalCountdowns();
</script>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/partials/user-header.blade.php ENDPATH**/ ?>