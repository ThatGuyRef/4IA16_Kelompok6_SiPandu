<x-admin-layout>
    <x-slot name="header">
        {{-- Header slot: consumers can pass header content via <x-slot name="header"> --}}
        {{ $header ?? '' }}
    </x-slot>

    <div class="flex h-screen bg-gray-100">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-300 shadow-none flex flex-col">
            <!-- Brand -->
            <div class="p-4">
                <div class="flex gap-3 items-center px-3">
<img src="{{ asset('image/Q4N4Yo6uW2o4CK75NwmlR5tfJcUqxCdTqJHqKJad.jpg') }}" alt="SI-PANDU" class="rounded-full w-10 h-10 object-cover" />
                    <div class="flex flex-col">
                        <h1 class="text-[#111418] text-base font-bold leading-normal">SI-PANDU</h1>
                        <p class="text-[#617589] text-sm leading-normal">Kelurahan Jati</p>
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
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">Dashboard</a>
                            <a href="{{ route('permohonan.warga.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('permohonan.warga.create') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">Buat Permohonan</a>
                            <a href="{{ route('permohonan.warga.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('permohonan.warga.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">Permohonan Saya</a>
                        @endif
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">
                                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">dashboard</span>
                                <span class="{{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Dashboard</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">groups</span>
                                <span class="text-[#111418] dark:text-gray-300">Manajemen Penduduk</span>
                            </a>
                            <a href="{{ route('admin.permohonan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.permohonan.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-colors">
                                <span class="material-symbols-outlined {{ request()->routeIs('admin.permohonan.*') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">description</span>
                                <span class="{{ request()->routeIs('admin.permohonan.*') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Kelola Permohonan</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">assessment</span>
                                <span class="text-[#111418] dark:text-gray-300">Laporan</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">settings</span>
                                <span class="text-[#111418] dark:text-gray-300">Pengaturan</span>
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
                            <span class="text-[#111418] dark:text-gray-300">Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</x-admin-layout>
