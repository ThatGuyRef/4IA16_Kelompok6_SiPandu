<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Permohonan Saya') }}</h2>
    </x-slot>

    <div class="dashboard-container">
        <div class="container">
            <div class="card">
                <a href="{{ route('permohonan.warga.create') }}" class="btn btn-primary mb-3">Buat Permohonan Baru</a>

                @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

                <table class="table table-striped">
                    <thead>
                        <tr><th>ID</th><th>Jenis</th><th>Status</th><th>Waktu</th></tr>
                    </thead>
                    <tbody>
                    @forelse($permohonans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->type }}</td>
                            <td>{{ $p->status }}</td>
                            <td>{{ $p->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada permohonan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
