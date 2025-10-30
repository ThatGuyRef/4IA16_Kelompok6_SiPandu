<x-dashboard-layout>
<x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div class="flex flex-col gap-1">
                <p class="text-[#111418] dark:text-white text-4xl font-bold leading-tight tracking-tight">Selamat Datang, Admin!</p>
                <p class="text-[#617589] dark:text-gray-400 text-base leading-normal">Beranda > Dashboard</p>
            </div>
            <div class="flex gap-2">
                <button class="p-2 text-[#111418] dark:text-white rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <span class="material-symbols-outlined">search</span>
                </button>
                <button class="relative p-2 text-[#111418] dark:text-white rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-1 right-1 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                </button>
            </div>
        </div>
    </x-slot>

<x-slot name="sidebar">
        <div class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">dashboard</span>
                <p class="{{ request()->routeIs('admin.dashboard') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }} text-sm font-medium leading-normal">Dashboard</p>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white hover:bg-opacity-10 transition-colors">
                <span class="material-symbols-outlined">groups</span>
                <span>Manajemen Penduduk</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'permohonan']) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ (request()->routeIs('admin.dashboard') && request()->get('section') === 'permohonan') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined {{ (request()->routeIs('admin.dashboard') && request()->get('section') === 'permohonan') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">description</span>
                <span class="{{ (request()->routeIs('admin.dashboard') && request()->get('section') === 'permohonan') ? 'text-primary dark:text-white' : 'text-[#111418] dark:text-gray-300' }}">Kelola Permohonan</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white hover:bg-opacity-10 transition-colors">
                <span class="material-symbols-outlined">assessment</span>
                <span>Laporan</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-white hover:bg-opacity-10 transition-colors">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan</span>
            </a>
        </div>
    </x-slot>


    <!-- Alert Banner -->
    <div class="card-elevated bg-blue-50 border-l-4 border-primary-500 text-blue-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <div class="py-1">
                <span class="material-symbols-outlined text-primary mr-4">notifications_active</span>
            </div>
            <div>
                <p class="font-bold">Pemberitahuan Pengajuan Baru!</p>
                <p class="text-sm">Ada <strong>{{ $pendingCount }}</strong> pengajuan surat baru yang menunggu untuk diproses. Silakan periksa halaman Kelola Permohonan.</p>
            </div>
        </div>
    </div>

    <!-- KPI Cards (Jumlah KK removed; realtime via polling) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="kpi">
            <p class="text-gray-800 text-base font-medium leading-normal">Total Penduduk</p>
            <p id="totalWargaValue" class="text-[#111418] tracking-light text-3xl font-bold leading-tight mt-1">{{ number_format($totalWarga ?? 0) }}</p>
        </div>
        <div class="kpi">
            <p class="text-gray-800 text-base font-medium leading-normal">Pengajuan Diproses</p>
            <p id="processingCountValue" class="text-[#111418] tracking-light text-3xl font-bold leading-tight mt-1">{{ number_format($processingCount ?? ($pendingCount ?? 0)) }}</p>
        </div>
        <div class="kpi">
            <p class="text-gray-800 text-base font-medium leading-normal">Pengajuan Selesai</p>
            <p id="approvedCountValue" class="text-[#111418] tracking-light text-3xl font-bold leading-tight mt-1">{{ number_format($approvedCount ?? 0) }}</p>
        </div>
    </div>

    <!-- Main Sections -->
    <div class="flex flex-col lg:flex-row gap-6 mt-6">
        <!-- Recent Submissions Table -->
        <div class="flex-1 card-elevated p-6">
            <h2 class="text-[#111418] text-xl font-bold leading-tight tracking-tight mb-4">Pengajuan Surat Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3" scope="col">No. Pengajuan</th>
                            <th class="px-4 py-3" scope="col">Nama Pemohon</th>
                            <th class="px-4 py-3" scope="col">Jenis Surat</th>
                            <th class="px-4 py-3" scope="col">Tanggal</th>
                            <th class="px-4 py-3" scope="col">Status</th>
                            <th class="px-4 py-3" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Permohonan::with('user')->latest()->limit(10)->get() as $p)
                            @php
                                $status = strtolower($p->status ?? 'pending');
                                $badgeClasses = match ($status) {
                                    'approved' => 'badge badge-green',
                                    'pending' => 'badge badge-yellow',
                                    'rejected' => 'badge badge-red',
                                    default => 'badge badge-blue',
                                };
                                $statusLabel = match ($status) {
                                    'approved' => 'Selesai',
                                    'pending' => 'Diproses',
                                    'rejected' => 'Ditolak',
                                    default => ucfirst($status),
                                };
                            @endphp
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">#{{ $p->id }}</td>
                                <td class="px-4 py-3">{{ $p->nama ?? optional($p->user)->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $p->type ?? '—' }}</td>
                                <td class="px-4 py-3">{{ optional($p->created_at)->format('Y-m-d') }}</td>
                                <td class="px-4 py-3">
                                    <span class="{{ $badgeClasses }}">{{ $statusLabel }}</span>
                                </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.permohonan.show', $p) }}" class="text-primary-700 hover:text-primary-900">Detail</a>
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada permohonan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Quick Links Panel -->
        <div class="lg:w-1/3 card-elevated p-6">
            <h2 class="text-[#111418] text-xl font-bold leading-tight tracking-tight mb-4">Tautan Cepat</h2>
            <div class="flex flex-col gap-4">
                <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100" href="#">
                    <span class="material-symbols-outlined text-primary text-3xl">person_add</span>
                    <p class="text-[#111418] font-medium">Tambah Data Penduduk Baru</p>
                </a>
                <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100" href="{{ route('admin.dashboard', ['section' => 'permohonan']) }}">
                    <span class="material-symbols-outlined text-primary text-3xl">add_to_drive</span>
                    <p class="text-[#111418] font-medium">Kelola Permohonan</p>
                </a>
                <a class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 hover:bg-gray-100" href="#">
                    <span class="material-symbols-outlined text-primary text-3xl">summarize</span>
                    <p class="text-[#111418] font-medium">Lihat Laporan Bulanan</p>
                </a>
            </div>
        </div>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const format = new Intl.NumberFormat();
    function setValue(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = format.format((value == null) ? 0 : value);
    }
    async function refreshMetrics() {
        try {
            const res = await fetch("{{ route('admin.metrics') }}", { headers: { "X-Requested-With": "XMLHttpRequest" } });
            if (!res.ok) return;
            const d = await res.json();
            setValue('totalWargaValue', d.totalWarga);
            setValue('processingCountValue', (d.processingCount != null) ? d.processingCount : d.pendingCount);
            setValue('approvedCountValue', d.approvedCount);
        } catch (e) {
            // silent
        }
    }
    refreshMetrics();
    setInterval(refreshMetrics, 5000);
});
</script>
@endpush
</x-dashboard-layout>
