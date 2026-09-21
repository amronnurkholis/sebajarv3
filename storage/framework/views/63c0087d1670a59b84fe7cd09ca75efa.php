<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo $__env->yieldContent('title', 'Admin'); ?> — Sebajar.id
    </title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-[#F8F5EF] text-[#2C2926]">

<div class="flex min-h-screen">

    
    <aside class="hidden w-64 shrink-0 border-r border-[#E7E0D6] bg-[#FBF9F5] lg:flex lg:flex-col">

        
        <div class="flex h-20 items-center border-b border-[#E7E0D6] px-7">

            <div>

                <div class="text-xl font-bold tracking-tight text-[#7B1E2B]">
                    Sebajar<span class="text-[#2C2926]">.id</span>
                </div>

                <div class="mt-0.5 text-[10px] uppercase tracking-[0.25em] text-[#8C847B]">
                    Admin Panel
                </div>

            </div>

        </div>


        
        <nav class="flex-1 px-4 py-6">

            <p class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#A39A90]">
                Menu Utama
            </p>


            
            <a
                href="<?php echo e(route('admin.dashboard')); ?>"
                class="mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm leading-5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] focus-visible:ring-offset-2
                    <?php echo e(request()->routeIs('admin.dashboard')
                        ? 'bg-[#7B1E2B] font-medium text-white shadow-sm'
                        : 'text-[#5F5953] hover:bg-[#F1ECE5] hover:text-[#7B1E2B]'); ?>"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                    />
                </svg>

                Dashboard

            </a>


            
            <a
                href="<?php echo e(route('admin.costumes.index')); ?>"
                class="mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm leading-5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] focus-visible:ring-offset-2
                    <?php echo e(request()->routeIs('admin.costumes.*')
                        ? 'bg-[#7B1E2B] font-medium text-white shadow-sm'
                        : 'text-[#5F5953] hover:bg-[#F1ECE5] hover:text-[#7B1E2B]'); ?>"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m0 10V11"
                    />
                </svg>

                Kostum

            </a>

            
            <a
                href="<?php echo e(route('admin.rentals.index')); ?>"
                class="mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm leading-5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] focus-visible:ring-offset-2
                    <?php echo e(request()->routeIs('admin.rentals.*')
                    ? 'bg-[#7B1E2B] font-medium text-white shadow-sm'
                    : 'text-[#5F5953] hover:bg-[#F1ECE5] hover:text-[#7B1E2B]'); ?>"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 7V3m8 4V3M4 10h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
                    />
                </svg>

                Pengajuan Sewa

            </a>


            
            <a
                href="<?php echo e(route('admin.users.index')); ?>"
                class="mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm leading-5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] focus-visible:ring-offset-2
                    <?php echo e(request()->routeIs('admin.users.*')
                        ? 'bg-[#7B1E2B] font-medium text-white shadow-sm'
                        : 'text-[#5F5953] hover:bg-[#F1ECE5] hover:text-[#7B1E2B]'); ?>"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m9-10a4 4 0 100-8 4 4 0 000 8zm7-4v6m3-3h-6"
                    />
                </svg>

                Pengguna

            </a>


            
            <p class="mb-3 mt-8 px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#A39A90]">
                Sistem
            </p>


            <a
                href="<?php echo e(route('admin.settings.edit')); ?>"
                class="mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm leading-5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] focus-visible:ring-offset-2
                    <?php echo e(request()->routeIs('admin.settings.*')
                        ? 'bg-[#7B1E2B] font-medium text-white shadow-sm'
                        : 'text-[#5F5953] hover:bg-[#F1ECE5] hover:text-[#7B1E2B]'); ?>"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.8 1.8-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V20H11.1v-.1a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.8-1.8.06-.06A1.7 1.7 0 006.73 15a1.7 1.7 0 00-1.56-1.03H5V11.4h.17A1.7 1.7 0 006.73 10a1.7 1.7 0 00-.34-1.88l-.06-.06 1.8-1.8.06.06a1.7 1.7 0 001.88.34A1.7 1.7 0 0011.1 5.1V5h2.54v.1a1.7 1.7 0 001.03 1.56 1.7 1.7 0 001.88-.34l.06-.06 1.8 1.8-.06.06A1.7 1.7 0 0019.4 10a1.7 1.7 0 001.56 1.03H21V14h-.04A1.7 1.7 0 0019.4 15z"
                    />
                </svg>

                Pengaturan

            </a>

        </nav>


        
        <div class="border-t border-[#E7E0D6] p-4">

            <div class="flex items-center gap-3 rounded-xl bg-[#F1ECE5] p-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#7B1E2B] text-sm font-semibold text-white">
                    <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-semibold text-[#332E2A]">
                        <?php echo e(auth()->user()->name ?? 'Administrator'); ?>

                    </p>

                    <p class="text-xs text-[#8C847B]">
                        Administrator
                    </p>

                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">

                    <?php echo csrf_field(); ?>

                    <button
                        type="submit"
                        title="Logout"
                        class="rounded-lg p-2 text-[#8C847B] transition-colors duration-150 hover:bg-white hover:text-[#7B1E2B] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B]"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 17l5-5-5-5m5 5H3m9-9V3a1 1 0 011-1h6a1 1 0 011 1v18a1 1 0 01-1 1h-6a1 1 0 01-1-1v-2"
                            />
                        </svg>

                    </button>

                </form>

            </div>

        </div>

    </aside>


    
    <div id="adminMobileOverlay" class="fixed inset-0 z-40 hidden bg-black/30 lg:hidden" aria-hidden="true"></div>
    <aside id="adminMobileDrawer" class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-[#E7E0D6] bg-[#FBF9F5] shadow-2xl transition-transform duration-200 lg:hidden">
        <div class="flex h-20 items-center justify-between border-b border-[#E7E0D6] px-6">
            <div><div class="text-xl font-bold text-[#7B1E2B]">Sebajar<span class="text-[#2C2926]">.id</span></div><div class="text-[10px] uppercase tracking-[0.25em] text-[#8C847B]">Admin Panel</div></div>
            <button type="button" id="adminMobileClose" class="rounded-lg p-2 text-[#7B1E2B] transition-colors duration-150 hover:bg-[#F1ECE5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B]" aria-label="Tutup menu">×</button>
        </div>
        <nav class="px-4 py-6">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="mb-1 flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[#7B1E2B] text-white' : 'text-[#5F5953] hover:bg-[#F1ECE5]'); ?>"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10.5 9-7 9 7v9a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 19.5v-9Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-6h6v6"/></svg>Dashboard</a>
            <a href="<?php echo e(route('admin.costumes.index')); ?>" class="mb-1 flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] <?php echo e(request()->routeIs('admin.costumes.*') ? 'bg-[#7B1E2B] text-white' : 'text-[#5F5953] hover:bg-[#F1ECE5]'); ?>"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m21 16-9 5-9-5m18-8-9 5-9-5m18 0L12 3 3 8"/></svg>Kostum</a>
            <a href="<?php echo e(route('admin.rentals.index')); ?>" class="mb-1 flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] <?php echo e(request()->routeIs('admin.rentals.*') ? 'bg-[#7B1E2B] text-white' : 'text-[#5F5953] hover:bg-[#F1ECE5]'); ?>"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 2v4m8-4v4M3.5 9h17M5 4h14a1.5 1.5 0 0 1 1.5 1.5v14A1.5 1.5 0 0 1 19 21H5a1.5 1.5 0 0 1-1.5-1.5v-14A1.5 1.5 0 0 1 5 4Z"/><path stroke-linecap="round" d="M8 13h8m-8 4h5"/></svg>Pengajuan Sewa</a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="mb-1 flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] <?php echo e(request()->routeIs('admin.users.*') ? 'bg-[#7B1E2B] text-white' : 'text-[#5F5953] hover:bg-[#F1ECE5]'); ?>"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 18.75a6.75 6.75 0 0 0-13.5 0m6.75-9a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Zm9 1.5v6m3-3h-6"/></svg>Pengguna</a>
            <a href="<?php echo e(route('admin.settings.edit')); ?>" class="mb-1 flex min-h-11 items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-[#7B1E2B] text-white' : 'text-[#5F5953] hover:bg-[#F1ECE5]'); ?>"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3a2.25 2.25 0 0 1 4.5 0l.2 1.3a7.9 7.9 0 0 1 1.7.99l1.23-.5a2.25 2.25 0 0 1 3.18 3.18l-.5 1.23c.4.53.73 1.1.98 1.7l1.31.2a2.25 2.25 0 0 1 0 4.5l-1.31.2a7.9 7.9 0 0 1-.98 1.7l.5 1.23a2.25 2.25 0 0 1-3.18 3.18l-1.23-.5a7.9 7.9 0 0 1-1.7.98l-.2 1.31a2.25 2.25 0 0 1-4.5 0l-.2-1.31a7.9 7.9 0 0 1-1.7-.98l-1.23.5a2.25 2.25 0 0 1-3.18-3.18l.5-1.23a7.9 7.9 0 0 1-.98-1.7l-1.31-.2a2.25 2.25 0 0 1 0-4.5l1.31-.2c.25-.6.58-1.17.98-1.7l-.5-1.23a2.25 2.25 0 0 1 3.18-3.18l1.23.5c.53-.4 1.1-.73 1.7-.99L9.75 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13.5A3 3 0 1 1 9 13.5a3 3 0 0 1 6 0Z"/></svg>Pengaturan</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-6 border-t border-[#E7E0D6] pt-4"><?php echo csrf_field(); ?><button class="flex min-h-11 w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-[#7B1E2B] transition-colors duration-150 hover:bg-[#F1ECE5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B]"><svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m-4.5-3h10.5m0 0-3-3m3 3-3 3"/></svg>Keluar</button></form>
        </nav>
    </aside>

    
    <main class="min-w-0 flex-1">

        
        <header class="flex h-20 items-center justify-between border-b border-[#E7E0D6] bg-[#FBF9F5] px-5 sm:px-8">

            <div class="flex items-center gap-3">
                <button type="button" id="adminMobileOpen" class="grid h-10 w-10 place-items-center rounded-xl border border-[#E7E0D6] bg-white text-[#7B1E2B] transition-colors duration-150 hover:bg-[#F8F1EC] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] lg:hidden" aria-label="Buka menu">☰</button>

                <p class="text-xs font-medium uppercase tracking-[0.16em] text-[#9B9187]">
                    Admin Panel
                </p>

                <h1 class="mt-1 text-xl font-semibold tracking-tight text-[#2C2926]">
                    <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                </h1>

            </div>


            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">

                    <p class="text-sm font-medium text-[#332E2A]">
                        <?php echo e(auth()->user()->name ?? 'Administrator'); ?>

                    </p>

                    <p class="text-xs text-[#9B9187]">
                        <?php echo e(now()->translatedFormat('l, d F Y')); ?>

                    </p>

                </div>

                <a href="<?php echo e(route('admin.settings.edit')); ?>" title="Profil & Pengaturan" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#DCCFC3] bg-white text-sm font-semibold text-[#7B1E2B] transition-colors duration-150 hover:border-[#7B1E2B] hover:bg-[#F8F1EC] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#7B1E2B] focus-visible:ring-offset-2">
                    <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

                </a>

            </div>

        </header>


        
        <div class="p-5 sm:p-8">

            <?php echo $__env->yieldContent('content'); ?>

        </div>

    </main>

</div>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
(() => {
 const drawer=document.getElementById('adminMobileDrawer'), overlay=document.getElementById('adminMobileOverlay'), open=document.getElementById('adminMobileOpen'), close=document.getElementById('adminMobileClose');
 const setOpen=(v)=>{drawer?.classList.toggle('-translate-x-full',!v);overlay?.classList.toggle('hidden',!v);document.body.classList.toggle('overflow-hidden',v)};
 open?.addEventListener('click',()=>setOpen(true)); close?.addEventListener('click',()=>setOpen(false)); overlay?.addEventListener('click',()=>setOpen(false)); drawer?.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setOpen(false))); document.addEventListener('keydown',e=>{if(e.key==='Escape')setOpen(false)});
})();
</script>
</body>
</html>
<?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/layouts/admin.blade.php ENDPATH**/ ?>