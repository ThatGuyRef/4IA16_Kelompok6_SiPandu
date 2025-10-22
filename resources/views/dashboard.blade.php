<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="hero">
                <div class="flex items-center justify-between gap-6 flex-col sm:flex-row">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold heading-gradient">Selamat datang, {{ Auth::user()->name }} 👋</h1>
                        <p class="mt-2 text-gray-600">Akses cepat ke informasi dan layanan untuk warga.</p>
                        <div class="mt-4 flex gap-3">
                            <a href="#" class="btn-primary">Buat Layanan</a>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white text-primary-600 border border-primary-200 rounded-lg shadow-sm hover:bg-primary-50">Edit Profil</a>
                        </div>
                    </div>

                    <div class="hidden sm:block">
                        <img src="/build/assets/illustration-dashboard.svg" alt="Dashboard illustration" class="w-48 h-auto">
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="card">
                    <h3 class="text-lg font-semibold">Permohonan Saya</h3>
                    <p class="mt-2 text-sm text-gray-500">Lihat status permohonan yang Anda ajukan.</p>
                </div>

                <div class="card">
                    <h3 class="text-lg font-semibold">Informasi Publik</h3>
                    <p class="mt-2 text-sm text-gray-500">Berita dan pengumuman terbaru dari kelurahan.</p>
                </div>

                <div class="card">
                    <h3 class="text-lg font-semibold">Kontak Darurat</h3>
                    <p class="mt-2 text-sm text-gray-500">Nomor penting dan panduan cepat.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
