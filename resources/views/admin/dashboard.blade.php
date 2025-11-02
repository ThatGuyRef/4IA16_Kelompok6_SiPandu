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
                                <td class="px-4 py-3">
                                    <time data-relative-time="{{ optional($p->created_at)->toIso8601String() }}" title="{{ optional($p->created_at)->format('d M Y H:i') }}">
                                        {{ optional($p->created_at)->format('Y-m-d') }}
                                    </time>
                                </td>
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
                                    </div>
                                    </x-dashboard-layout>
