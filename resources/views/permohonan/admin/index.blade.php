<x-dashboard-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Pengelolaan Pengajuan Surat</h1>
                <p class="text-gray-500 dark:text-gray-400">Kelola semua pengajuan surat dari warga di satu tempat.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('status'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-800 px-4 py-3">{{ session('status') }}</div>
        @endif

        <div class="flex flex-col gap-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="flex flex-col min-w-40 h-12 w-full">
                        <div class="flex w-full flex-1 items-stretch rounded-lg h-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <div class="text-gray-500 dark:text-gray-400 flex items-center justify-center pl-4 rounded-l-lg border-r-0">
                                <span class="material-symbols-outlined">search</span>
                            </div>
                            <input name="q" value="{{ $q ?? request('q') }}" class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-0 border-none bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 pl-2 text-base" placeholder="Cari nama pemohon, NIK, atau jenis surat" />
                        </div>
                    </label>
                </div>
                <div class="flex gap-2 items-center">
                    <select name="status" class="h-12 rounded-lg bg-white dark:bg-gray-800 px-4 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                        <option value="">Status: Semua</option>
                        @foreach(['pending'=>'Pending','processing'=>'Diproses','approved'=>'Disetujui','rejected'=>'Ditolak'] as $val=>$label)
                            <option value="{{ $val }}" @selected(($status ?? request('status'))===$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="type" class="h-12 rounded-lg bg-white dark:bg-gray-800 px-4 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                        <option value="all">Jenis Surat: Semua</option>
                        @foreach(($types ?? []) as $t)
                            <option value="{{ $t }}" @selected(($type ?? request('type'))===$t)>{{ ucwords(str_replace(['_','-'],' ', $t)) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="h-12 inline-flex items-center justify-center rounded-lg bg-primary px-4 text-white">Filter</button>
                </div>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300">Nomor</th>
                                <th class="px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300">Nama Pemohon</th>
                                <th class="px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300">Jenis Surat</th>
                                <th class="px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300">Tanggal</th>
                                <th class="px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300">Status</th>
                                <th class="px-4 py-3 text-sm font-medium text-gray-600 dark:text-gray-300 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($permohonans as $p)
                                @php
                                    $status = strtolower($p->status ?? 'pending');
                                    $badge = match($status){
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                    $statusLabel = match($status){
                                        'approved' => 'Disetujui',
                                        'pending' => 'Pending',
                                        'processing' => 'Diproses',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst($status),
                                    };
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">#{{ $p->id }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $p->nama ?? optional($p->user)->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ ucwords(str_replace(['_','-'],' ', $p->type ?? '—')) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                        <time data-relative-time="{{ optional($p->created_at)->toIso8601String() }}" title="{{ optional($p->created_at)->format('d M Y H:i') }}">
                                            {{ optional($p->created_at)->format('d/m/Y') }}
                                        </time>
                                    </td>
                                    <td class="px-4 py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">{{ $statusLabel }}</span></td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex gap-2 justify-end">
                                            <a href="{{ route('admin.permohonan.show', $p) }}" class="p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400" title="Lihat"><span class="material-symbols-outlined text-base">visibility</span></a>
                                            <form method="POST" action="{{ route('admin.permohonan.update', $p) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved" />
                                                <button type="submit" class="p-1.5 rounded-md {{ $status==='approved' ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-green-100 dark:hover:bg-green-900/50 text-green-600 dark:text-green-400' }}" {{ $status==='approved' ? 'disabled' : '' }} title="Setujui">
                                                    <span class="material-symbols-outlined text-base">check_circle</span>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.permohonan.update', $p) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected" />
                                                <button type="submit" class="p-1.5 rounded-md {{ in_array($status,['rejected']) ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400' }}" {{ in_array($status,['rejected']) ? 'disabled' : '' }} title="Tolak">
                                                    <span class="material-symbols-outlined text-base">cancel</span>
                                                </button>
                                            </form>
                                            <button class="p-1.5 rounded-md {{ $status==='approved' ? 'hover:bg-blue-100 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400' : 'text-gray-400 cursor-not-allowed' }}" {{ $status!=='approved' ? 'disabled' : '' }} title="Cetak">
                                                <span class="material-symbols-outlined text-base">print</span>
                                            </button>
                                        </div>
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
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row gap-3 sm:gap-0 sm:items-center sm:justify-between">
                    @php
                        $from = ($permohonans->currentPage() - 1) * $permohonans->perPage() + 1;
                        $to = min($permohonans->currentPage() * $permohonans->perPage(), $permohonans->total());
                    @endphp
                    <p class="text-sm text-gray-500 dark:text-gray-400">Menampilkan {{ $from }}-{{ $to }} dari {{ $permohonans->total() }} hasil</p>
                    <div class="flex gap-2">
                        {{ $permohonans->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
