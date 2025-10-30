<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="dashboard-container">
        <div class="container">
            <div class="dashboard-grid">
                <div class="dashboard-welcome">
                    <div class="dashboard-welcome-header">
                        <div>
                            <h1 class="dashboard-welcome-title">Selamat datang, {{ Auth::user()->name }} 👋</h1>
                            <p class="dashboard-welcome-subtitle">Akses cepat ke informasi dan layanan untuk warga.</p>
                        </div>
                        @if(Auth::user()->role === 'warga')
                            <div>
                                <a href="{{ route('permohonan.warga.create') }}" class="btn btn-primary">Buat Permohonan</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="dashboard-info-grid">
                    <div class="dashboard-info-card">
                        <h3 class="dashboard-info-title">Informasi Publik</h3>
                        <p class="dashboard-info-text">Berita dan pengumuman terbaru dari kelurahan.</p>
                    </div>
                    <div class="dashboard-info-card">
                        <h3 class="dashboard-info-title">Kontak Darurat</h3>
                        <p class="dashboard-info-text">Nomor penting dan panduan cepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
