<x-dashboard-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div class="flex flex-col gap-1">
                <div class="flex flex-wrap gap-2 text-sm text-slate-600 dark:text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('admin.permohonan.index') }}" class="hover:text-primary">Daftar Permohonan</a>
                    <span>/</span>
                    <span class="text-slate-900 dark:text-white">#{{ $permohonan->id }}</span>
                </div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white">Detail Permohonan: #{{ $permohonan->id }}</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.permohonan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $p = $permohonan;
        $statusKey = strtolower($p->status ?? 'pending');
        $statusBadge = match($statusKey){
            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            default => 'bg-slate-100 text-slate-800 dark:bg-gray-700 dark:text-gray-300',
        };
        $statusLabel = match($statusKey){
            'approved' => 'Disetujui',
            'processing' => 'Diproses',
            'pending' => 'Menunggu Verifikasi',
            'rejected' => 'Ditolak',
            default => ucfirst($statusKey),
        };
        $dokumen = is_array($p->dokumen_json ?? null) ? $p->dokumen_json : [];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 flex flex-col gap-8">
                <!-- Informasi Pemohon -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Pemohon</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                        <div class="flex flex-col gap-1 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Nama Lengkap</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ $p->nama ?? optional($p->user)->name ?? '—' }}</p>
                        </div>
                        <div class="flex flex-col gap-1 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">NIK</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ $p->nik ?? optional($p->user)->nik ?? '—' }}</p>
                        </div>
                        <div class="flex flex-col gap-1 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">No. Telepon</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ $p->phone ?? '—' }}</p>
                        </div>
                        <div class="flex flex-col gap-1 border-t border-gray-200 dark:border-gray-700 pt-4 sm:col-span-2">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Alamat</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ $p->alamat ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Permohonan -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Detail Permohonan</h2>
                    <div class="grid grid-cols-1 gap-y-5">
                        <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Jenis Surat</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ ucwords(str_replace(['_','-'],' ', $p->type ?? '—')) }}</p>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Tanggal Pengajuan</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm font-medium">{{ optional($p->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Status Terkini</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusBadge }}">{{ $statusLabel }}</span>
                        </div>
                        @if($p->notes)
                        <div class="flex justify-between items-start border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Catatan</p>
                            <div class="text-gray-800 dark:text-gray-200 text-sm font-medium max-w-xl text-right">{!! nl2br(e($p->notes)) !!}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Dokumen Terlampir -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Dokumen Terlampir</h2>
                    @if($dokumen)
                        <ul class="space-y-3">
                            @foreach($dokumen as $type => $fields)
                                <li class="mb-4">
                                    <div class="text-sm font-semibold mb-2">{{ ucwords(str_replace(['_','-'],' ', $type)) }}</div>
                                    <div class="space-y-2">
                                        @foreach($fields as $field => $path)
                                            @php $url = $path ? asset('storage/'.$path) : null; @endphp
                                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                                <div class="flex items-center gap-3">
                                                    <span class="material-symbols-outlined text-primary">description</span>
                                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ ucwords(str_replace(['_','-'],' ', $field)) }}</span>
                                                </div>
                                                <div>
                                                    @if($url)
                                                        <a href="{{ $url }}" target="_blank" class="flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                                                            <span class="material-symbols-outlined text-base">visibility</span>
                                                            Lihat
                                                        </a>
                                                    @else
                                                        <span class="text-sm text-red-600">(tidak ditemukan)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-slate-500">Tidak ada dokumen terlampir.</p>
                    @endif
                </div>

                <!-- Riwayat Status (sederhana) -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Riwayat Status</h2>
                    <div class="relative pl-6">
                        <div class="absolute left-[34px] h-full border-l-2 border-gray-200 dark:border-gray-700"></div>
                        <div class="relative mb-8">
                            <div class="absolute left-[-11px] top-1.5 size-6 rounded-full bg-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                            <div class="ml-8">
                                <p class="font-bold text-gray-800 dark:text-gray-200">Permohonan diajukan</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ optional($p->created_at)->format('d M Y, H:i') }}</p>
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Diajukan oleh {{ $p->nama ?? optional($p->user)->name ?? 'Pemohon' }}.</p>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="absolute left-[-11px] top-1.5 size-6 rounded-full {{ $statusKey==='approved' ? 'bg-green-600' : ($statusKey==='rejected' ? 'bg-red-600' : 'bg-yellow-500') }} flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-sm">{{ $statusKey==='approved' ? 'check_circle' : ($statusKey==='rejected' ? 'cancel' : 'hourglass_top') }}</span>
                            </div>
                            <div class="ml-8">
                                <p class="font-bold text-gray-800 dark:text-gray-200">Status Terkini: {{ $statusLabel }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ optional($p->updated_at)->format('d M Y, H:i') }}</p>
                                @if($p->notes)
                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ Str::limit(strip_tags($p->notes), 200) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Aksi Admin -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 bg-white dark:bg-gray-900 rounded-xl shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Aksi Admin</h2>
                    <form id="admin-action-form" method="POST" action="{{ route('admin.permohonan.update', $p) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" id="status-field" value="" />
                        <div>
                            <label for="internal-notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Internal (Opsional)</label>
                            <textarea id="internal-notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm" rows="3" placeholder="Catatan hanya untuk admin..."></textarea>
                        </div>
                        <div>
                            <label for="applicant-message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesan untuk Pemohon</label>
                            <textarea id="applicant-message" name="notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm" rows="4" placeholder="Tulis pesan jika meminta revisi atau menolak..."></textarea>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Unggah Dokumen Hasil (Wajib)</label>
                            <div class="space-y-2">
                                <input type="text" name="result_label" placeholder="Nama dokumen (mis. Surat Keterangan)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm" />
                                <input type="file" name="result_file" accept="application/pdf,image/*" class="block w-full text-sm text-gray-900 dark:text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90" />
                                <p class="text-xs text-gray-500">Format: PDF/JPG/PNG, maks 5MB.</p>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-3 pt-4">
                            @php $isApproved = ($statusKey==='approved'); $isRejected = ($statusKey==='rejected'); @endphp
                            <button type="button" data-status="approved" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-700 hover:bg-green-800 disabled:opacity-50" {{ $isApproved ? 'disabled' : '' }}>
                                <span class="material-symbols-outlined mr-2">check_circle</span>
                                Setujui Permohonan
                            </button>
                            <button type="button" data-status="processing" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 disabled:opacity-50">
                                <span class="material-symbols-outlined mr-2">edit</span>
                                Minta Revisi
                            </button>
                            <button type="button" data-status="rejected" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-700 hover:bg-red-800 disabled:opacity-50" {{ $isRejected ? 'disabled' : '' }}>
                                <span class="material-symbols-outlined mr-2">cancel</span>
                                Tolak Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('admin-action-form');
        const statusField = document.getElementById('status-field');
        form.querySelectorAll('button[data-status]').forEach(btn => {
            btn.addEventListener('click', () => {
                const status = btn.getAttribute('data-status');
                statusField.value = status;
                form.submit();
            });
        });
    });
    </script>
    @endpush
</x-dashboard-layout>
