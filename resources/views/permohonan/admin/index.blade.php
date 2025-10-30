<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Permohonan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

                <table class="table table-hover">
                    <thead><tr><th>ID</th><th>User</th><th>Jenis</th><th>Status</th><th>Waktu</th><th></th></tr></thead>
                    <tbody>
                    @foreach($permohonans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->user->name }} ({{ $p->user->nik }})</td>
                            <td>{{ $p->type }}</td>
                            <td>{{ $p->status }}</td>
                            <td>{{ $p->created_at->format('Y-m-d H:i') }}</td>
                            <td><a href="{{ route('admin.permohonan.show', $p) }}" class="btn btn-sm btn-outline-primary">Lihat</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $permohonans->links() }}
            </div>
        </div>
    </div>
</x-dashboard-layout>
