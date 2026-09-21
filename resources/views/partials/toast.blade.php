@if (session('success') || session('error') || session('warning'))
    @php
        $toastType = session('success') ? 'success' : (session('error') ? 'error' : 'warning');
        $toastTitle = $toastType === 'success' ? 'Berhasil' : ($toastType === 'error' ? 'Terjadi masalah' : 'Perhatian');
        $toastMessage = session($toastType);
    @endphp
    <div class="sebajar-toast-wrap" aria-live="polite" aria-atomic="true">
        <div class="sebajar-toast sebajar-toast-{{ $toastType }}" data-toast role="status">
            <span class="sebajar-toast-icon" aria-hidden="true">
                @if($toastType === 'success')
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="m8 12 2.6 2.6L16.5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @elseif($toastType === 'error')
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 8v5m0 3h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                @else
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 4 21 20H3L12 4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M12 9v5m0 3h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                @endif
            </span>
            <div><strong>{{ $toastTitle }}</strong><p>{{ $toastMessage }}</p></div>
            <button type="button" class="sebajar-toast-close" data-toast-close aria-label="Tutup">×</button>
        </div>
    </div>
@endif

<style>
.sebajar-toast-wrap{position:fixed;top:22px;right:22px;z-index:99999;width:min(390px,calc(100vw - 28px));pointer-events:none}.sebajar-toast{pointer-events:auto;display:grid;grid-template-columns:auto 1fr auto;gap:11px;align-items:start;padding:14px 15px;border:1px solid #e7e0d6;border-radius:14px;background:#fff;box-shadow:0 14px 35px rgba(44,41,38,.14);animation:sebajarToastIn .28s ease-out}.sebajar-toast-icon{width:24px;height:24px;display:grid;place-items:center}.sebajar-toast-icon svg{width:22px;height:22px}.sebajar-toast-success .sebajar-toast-icon{color:#2f7a45}.sebajar-toast-error .sebajar-toast-icon{color:#a9343d}.sebajar-toast-warning .sebajar-toast-icon{color:#a06b15}.sebajar-toast strong{display:block;font-size:13px;color:#332e2a}.sebajar-toast p{margin:2px 0 0;font-size:12px;line-height:1.5;color:#655d56}.sebajar-toast-close{border:0;background:transparent;color:#8c847b;font-size:20px;line-height:1;cursor:pointer;padding:0 2px}.sebajar-toast.is-leaving{animation:sebajarToastOut .25s ease-in forwards}@keyframes sebajarToastIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}@keyframes sebajarToastOut{to{opacity:0;transform:translateY(-8px)}}@media(max-width:600px){.sebajar-toast-wrap{top:12px;right:12px;width:calc(100vw - 24px)}}
</style>
<script>
(() => { const toast=document.querySelector('[data-toast]'); if(!toast) return; const close=()=>toast.classList.add('is-leaving'); const btn=toast.querySelector('[data-toast-close]'); if(btn) btn.addEventListener('click',close); setTimeout(close,4500); setTimeout(()=>toast.remove(),4800); })();
</script>
