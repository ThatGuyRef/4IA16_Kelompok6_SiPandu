<nav x-data="{ open: false }" class="nav">
    <!-- Primary Navigation Menu -->
    <div class="nav-container">
        <div class="nav-wrapper">
            <div class="nav-left">
                <!-- Logo -->
                <div class="nav-logo">
                    @php
                        $homeRoute = (Auth::check() && Auth::user()->role === 'admin') ? route('admin.dashboard') : route('dashboard');
                    @endphp
                    <a href="{{ $homeRoute }}" class="nav-logo-link">
                        <x-application-logo class="nav-logo-image" />
                        <span class="nav-logo-text">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="nav-links">
                    @if(!request()->routeIs('dashboard') && !request()->routeIs('admin.dashboard'))
                        @auth
                            @php $dashRoute = (Auth::user()->role === 'admin') ? route('admin.dashboard') : route('dashboard'); @endphp
                        @else
                            @php $dashRoute = route('dashboard'); @endphp
                        @endauth
                        <x-nav-link :href="$dashRoute" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        @auth
                            @if(Auth::user()->role === 'warga')
                                <x-nav-link :href="route('permohonan.warga.create')" :active="request()->routeIs('permohonan.warga.create')">
                                    {{ __('Buat Permohonan') }}
                                </x-nav-link>
                                <x-nav-link :href="route('permohonan.warga.index')" :active="request()->routeIs('permohonan.warga.*')">
                                    {{ __('Permohonan Saya') }}
                                </x-nav-link>
                            @elseif(Auth::user()->role === 'admin')
                                <x-nav-link :href="route('admin.permohonan.index')" :active="request()->routeIs('admin.permohonan.*')">
                                    {{ __('Laporan Permohonan') }}
                                </x-nav-link>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="nav-right">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="dropdown-trigger">
                                <div>{{ Auth::user()->name }}</div>

                                <div style="margin-left: 0.25rem;">
                                    <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @if(Auth::user()->role === 'warga')
                                <x-dropdown-link :href="route('permohonan.warga.index')">{{ __('Permohonan Saya') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('permohonan.warga.create')">{{ __('Buat Permohonan') }}</x-dropdown-link>
                            @elseif(Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.permohonan.index')">{{ __('Laporan Permohonan') }}</x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            @php
                                $logoutRoute = (Auth::user()?->role === 'warga') ? route('warga.logout') : route('logout');
                            @endphp
                            <form method="POST" action="{{ $logoutRoute }}">
                                @csrf

                                <x-dropdown-link :href="$logoutRoute"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex gap-3">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm" style="color: var(--color-primary);">Register</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="nav-hamburger">
                <button @click="open = ! open" class="nav-hamburger-button">
                    <svg class="nav-hamburger-icon" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'active': open}" class="nav-mobile">
        @if(!request()->routeIs('dashboard') && !request()->routeIs('admin.dashboard'))
        <div class="nav-mobile-links">
            @auth
                @php $dashRoute = (Auth::user()->role === 'admin') ? route('admin.dashboard') : route('dashboard'); @endphp
            @else
                @php $dashRoute = route('dashboard'); @endphp
            @endauth
            <x-responsive-nav-link :href="$dashRoute" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @endif

        <!-- Responsive Settings Options -->
        <div class="nav-mobile-user">
            @auth
                <div class="nav-mobile-user-info">
                    <div class="nav-mobile-user-name">{{ Auth::user()->name }}</div>
                    <div class="nav-mobile-user-email">{{ Auth::user()->email }}</div>
                </div>

                <div class="nav-mobile-user-links">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    @if(Auth::user()->role === 'warga')
                        <x-responsive-nav-link :href="route('permohonan.warga.create')">{{ __('Buat Permohonan') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('permohonan.warga.index')">{{ __('Permohonan Saya') }}</x-responsive-nav-link>
                    @elseif(Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('admin.permohonan.index')">{{ __('Laporan Permohonan') }}</x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    @php
                        $responsiveLogout = (Auth::user()?->role === 'warga') ? route('warga.logout') : route('logout');
                    @endphp
                    <form method="POST" action="{{ $responsiveLogout }}">
                        @csrf

                        <x-responsive-nav-link :href="$responsiveLogout"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="nav-mobile-user-info">
                    <div class="nav-mobile-user-links">
                        <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
                        @if (Route::has('register'))
                            <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
                        @endif
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
