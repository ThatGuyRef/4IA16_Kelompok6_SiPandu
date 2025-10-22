<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang, admin. Gunakan panel ini untuk manajemen.
                    <div class="mt-4">
                        <a href="{{ route('admin.permohonan.index') }}" class="btn btn-primary">Kelola Permohonan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
