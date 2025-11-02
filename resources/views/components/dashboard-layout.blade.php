<x-admin-layout>
    <x-slot name="header">
        {{-- Header slot: consumers can pass header content via <x-slot name="header"> --}}
        {{ $header ?? '' }}
    </x-slot>

    <style>
        /* Desktop collapsed state styling */
        @media (min-width: 768px) {
            #app-sidebar.sidebar-collapsed { width: 5rem; }
            #app-sidebar.sidebar-collapsed .brand-label,
            #app-sidebar.sidebar-collapsed .nav-label { display: none !important; }
            #app-sidebar.sidebar-collapsed .brand-logo { margin-left: auto; margin-right: auto; }
            #app-sidebar.sidebar-collapsed .nav-link { justify-content: center; }
        }
    </style>
    <div id="dashboard-shell" class="relative flex h-screen bg-gray-100">
        {{-- Sidebar --}}
        <aside id="app-sidebar" class="fixed md:static inset-y-0 left-0 z-40 w-64 transform -translate-x-full md:translate-x-0 transition-transform bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-300 shadow-none flex flex-col">
            <!-- Brand -->
            <div class="p-4">
                <div class="flex gap-3 items-center px-3">
<img src="{{ asset('image/Q4N4Yo6uW2o4CK75NwmlR5tfJcUqxCdTqJHqKJad.jpg') }}" alt="SI-PANDU" class="brand-logo rounded-full w-10 h-10 object-cover" />
                    <div class="flex flex-col">
                        <h1 class="brand-label text-[#111418] text-base font-bold leading-normal">SI-PANDU</h1>
                        <p class="brand-label text-[#617589] text-sm leading-normal">Kelurahan Jati</p>
                    </div>
                </div>
            </div>
            <!-- Nav -->
            <nav class="mt-2 flex-1">
                {{-- Default sidebar if none provided --}}
                @if(isset($sidebar))
                    {{ $sidebar }}
                @else
                    <div class="px-6 space-y-2">
                        @if(!(auth()->check() && auth()->user()->role === 'admin'))
                            @php
                                $isDash = request()->routeIs('dashboard');
                                $isCreate = request()->routeIs('permohonan.warga.create');
                                $isIndex = request()->routeIs('permohonan.warga.*');
                                $baseLink = 'flex items-center gap-3 px-3 py-2 rounded-lg transition-colors';
                                $active = 'bg-primary/20 dark:bg-primary/30';
                                $hover = 'hover:bg-gray-100 dark:hover:bg-gray-800';
                                $iconActive = 'text-primary dark:text-white';
                                $iconMuted = 'text-[#111418] dark:text-gray-300';
                            @endphp
                            <a href="{{ route('dashboard') }}" class="nav-link {{ $baseLink }} {{ $isDash ? $active : $hover }}">
                                <span class="material-symbols-outlined {{ $isDash ? $iconActive : $iconMuted }}">dashboard</span>
                                <span class="nav-label {{ $isDash ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Dashboard</span>
                            </a>
                            <a href="{{ route('permohonan.warga.create') }}" class="nav-link {{ $baseLink }} {{ $isCreate ? $active : $hover }}">
                                <span class="material-symbols-outlined {{ $isCreate ? $iconActive : $iconMuted }}">edit_document</span>
                                <span class="nav-label {{ $isCreate ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Buat Permohonan</span>
                            </a>
                            <a href="{{ route('permohonan.warga.index') }}" class="nav-link {{ $baseLink }} {{ $isIndex && ! $isCreate && ! $isDash ? $active : $hover }}">
                                <span class="material-symbols-outlined {{ ($isIndex && ! $isCreate && ! $isDash) ? $iconActive : $iconMuted }}">description</span>
                                <span class="nav-label {{ ($isIndex && ! $isCreate && ! $isDash) ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Permohonan Saya</span>
                            </a>
                        @endif
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">
                                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">dashboard</span>
                                <span class="nav-label {{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Dashboard</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">groups</span>
                                <span class="nav-label text-[#111418] dark:text-gray-300">Manajemen Penduduk</span>
                            </a>
                            <a href="{{ route('admin.permohonan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.permohonan.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">
                                <span class="material-symbols-outlined {{ request()->routeIs('admin.permohonan.*') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">description</span>
                                <span class="nav-label {{ request()->routeIs('admin.permohonan.*') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Kelola Permohonan</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">assessment</span>
                                <span class="nav-label text-[#111418] dark:text-gray-300">Laporan</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">settings</span>
                                <span class="nav-label text-[#111418] dark:text-gray-300">Pengaturan</span>
                            </a>
                        @endif
                    </div>
                @endif
            </nav>
            <!-- Logout at bottom -->
            @auth
                <div class="p-4 border-t border-gray-200 dark:border-white/10">
                    @php
                        $logoutRoute = (auth()->user()->role === 'warga') ? route('warga.logout') : route('logout');
                    @endphp
                    <form method="POST" action="{{ $logoutRoute }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">logout</span>
                            <span class="nav-label text-[#111418] dark:text-gray-300">Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

    <!-- Mobile overlay -->
    <div id="sidebar-overlay" class="hidden fixed inset-0 z-30 bg-black/30 backdrop-blur-sm md:hidden"></div>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Sidebar toggle button -->
            <button id="sidebar-toggle" type="button" aria-label="Toggle sidebar" title="Toggle sidebar" onclick="window.__onSidebarToggle && window.__onSidebarToggle(event)" class="fixed top-4 left-4 z-50 inline-flex items-center justify-center rounded-lg h-10 w-10 bg-white/90 dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow hover:bg-white">
                <span class="material-symbols-outlined" id="sidebar-toggle-icon">menu</span>
            </button>
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @push('scripts')
        <script>
            (function(){
                // Lightweight debug switch: set window.__SIDEBAR_DEBUG = true in console to log
                const dbg = (...args) => { try { if (window.__SIDEBAR_DEBUG) console.debug('[sidebar]', ...args); } catch(e) {} };

                function ready(fn){
                    if (document.readyState !== 'loading') fn();
                    else document.addEventListener('DOMContentLoaded', fn, { once: true });
                }

                ready(function(){
                    const sidebar = document.getElementById('app-sidebar');
                    const overlay = document.getElementById('sidebar-overlay');
                    const toggleBtn = document.getElementById('sidebar-toggle');
                    const toggleIcon = document.getElementById('sidebar-toggle-icon');
                    if (!sidebar || !toggleBtn || !toggleIcon) { dbg('elements missing', { sidebar: !!sidebar, toggleBtn: !!toggleBtn, toggleIcon: !!toggleIcon }); return; }

                    const mq = window.matchMedia('(max-width: 767px)');
                    const isMobile = () => mq.matches;

                    function positionToggle(){
                        if (isMobile()) {
                            toggleBtn.style.left = '1rem';
                        } else {
                            const collapsed = sidebar.classList.contains('sidebar-collapsed');
                            const sidebarWidth = collapsed ? 80 /* ~5rem */ : 256 /* 16rem */;
                            toggleBtn.style.left = (sidebarWidth + 16) + 'px';
                        }
                    }

                    function openSidebar(){
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        overlay && overlay.classList.remove('hidden');
                        toggleIcon.textContent = 'close';
                        sidebar.setAttribute('data-open', '1');
                        dbg('open mobile');
                    }
                    function closeSidebar(){
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
                        overlay && overlay.classList.add('hidden');
                        toggleIcon.textContent = 'menu';
                        sidebar.removeAttribute('data-open');
                        dbg('close mobile');
                    }

                    function setDesktopCollapsed(collapsed){
                        if (collapsed) {
                            sidebar.classList.add('sidebar-collapsed');
                            sidebar.setAttribute('data-collapsed', '1');
                        } else {
                            sidebar.classList.remove('sidebar-collapsed');
                            sidebar.removeAttribute('data-collapsed');
                        }
                        try { localStorage.setItem('sidebar_collapsed', collapsed ? '1' : '0'); } catch(e) {}
                        toggleIcon.textContent = (isMobile() ? (overlay && overlay.classList.contains('hidden') ? 'menu' : 'close') : (collapsed ? 'chevron_right' : 'chevron_left'));
                        positionToggle();
                        dbg('setDesktopCollapsed', collapsed);
                    }

                    function initState(){
                        if (isMobile()) {
                            closeSidebar();
                        } else {
                            // ensure mobile transform classes don't apply on desktop
                            sidebar.classList.remove('translate-x-0');
                            sidebar.classList.remove('-translate-x-full');
                            let persisted = false;
                            try { persisted = (localStorage.getItem('sidebar_collapsed') === '1'); } catch(e) {}
                            setDesktopCollapsed(persisted);
                        }
                        positionToggle();
                        dbg('init done', { mobile: isMobile() });
                    }

                    // Public fallback handler (in case other listeners fail)
                    window.__onSidebarToggle = function(ev){
                        try { ev && ev.preventDefault && ev.preventDefault(); } catch(e) {}
                        if (isMobile()) {
                            const closed = sidebar.classList.contains('-translate-x-full');
                            if (closed) openSidebar(); else closeSidebar();
                        } else {
                            const collapsed = sidebar.classList.contains('sidebar-collapsed');
                            setDesktopCollapsed(!collapsed);
                        }
                    };

                    // Primary event listeners
                    toggleBtn.addEventListener('click', window.__onSidebarToggle);
                    overlay && overlay.addEventListener('click', closeSidebar);

                    // Update on breakpoints/resize
                    if (mq && mq.addEventListener) mq.addEventListener('change', initState);
                    window.addEventListener('resize', positionToggle);

                    // Initial state
                    initState();
                });
            })();
        </script>
        @endpush
    @stack('scripts')
</x-admin-layout>
