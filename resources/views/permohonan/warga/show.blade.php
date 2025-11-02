<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto py-6">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl md:text-3xl font-black leading-tight tracking-[-0.03em]">Detail Permohonan</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Nomor Tiket: #{{ $permohonan->id }} • Diajukan <time data-relative-time="{{ $permohonan->created_at->toIso8601String() }}" title="{{ $permohonan->created_at->translatedFormat('d M Y H:i') }}">{{ $permohonan->created_at->format('Y-m-d H:i') }}</time></p>
            </div>
            <a href="{{ route('permohonan.warga.index') }}" class="inline-flex items-center gap-2 rounded-lg h-10 px-4 bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm font-semibold hover:bg-slate-200 dark:hover:bg-slate-700">
                <span class="material-symbols-outlined">history</span>
                <span>Kembali ke Riwayat</span>
            </a>
        </div>

        @php
            $typeLabels = [
                'pembuatan_akta_kelahiran' => 'Surat/ Akta Kelahiran',
                'pembaruan_akta_kelahiran' => 'Pembaruan Akta Kelahiran',
                'akta_nikah_islam' => 'Akta Nikah (Islam)',
                'akta_nikah_non_islam' => 'Akta Nikah (Non-Islam)',
                'akta_kematian' => 'Akta Kematian',
            ];
            $typeLabel = $typeLabels[$permohonan->type] ?? ucwords(str_replace('_',' ', $permohonan->type));
            $status = strtolower((string)$permohonan->status ?: 'menunggu');
            $statusMeta = match ($status) {
                'approved', 'selesai' => ['label' => 'Selesai', 'badge' => 'bg-green-100 dark:bg-green-500/20 text-green-800 dark:text-green-300', 'icon' => 'check_circle'],
                'rejected', 'ditolak' => ['label' => 'Ditolak', 'badge' => 'bg-red-100 dark:bg-red-500/20 text-red-800 dark:text-red-300', 'icon' => 'cancel'],
                'processing', 'diproses' => ['label' => 'Diproses', 'badge' => 'bg-sky-100 dark:bg-sky-500/20 text-sky-800 dark:text-sky-300', 'icon' => 'hourglass_top'],
                'revisi', 'perlu revisi' => ['label' => 'Perlu Revisi', 'badge' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300', 'icon' => 'edit'],
                default => ['label' => 'Menunggu', 'badge' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300', 'icon' => 'hourglass_bottom'],
            };
            $docs = is_array($permohonan->dokumen_json) ? ($permohonan->dokumen_json[$permohonan->type] ?? []) : [];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="bg-white dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] px-6 py-4 border-b border-slate-200 dark:border-slate-700">Data Permohonan</h2>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 mb-1">Jenis Surat</p>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $typeLabel }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 mb-1">Keperluan</p>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $permohonan->jenis_keperluan ? ucwords(str_replace('_',' ', $permohonan->jenis_keperluan)) : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 mb-1">Nama Lengkap</p>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $permohonan->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 mb-1">NIK</p>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $permohonan->nik ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-slate-500 dark:text-slate-400 mb-1">Alamat Lengkap</p>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $permohonan->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 flex flex-col gap-6">
                <div class="bg-white dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] px-6 py-4 border-b border-slate-200 dark:border-slate-700">Status & Dokumen</h2>
                    <div class="p-6 flex flex-col gap-6">
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Status Terkini</p>
                            <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-medium w-fit {{ $statusMeta['badge'] }}">
                                <span class="material-symbols-outlined text-sm">{{ $statusMeta['icon'] }}</span>
                                <span>{{ $statusMeta['label'] }}</span>
                            </div>
                            @if(!empty($permohonan->notes))
                                <p class="text-sm text-slate-600 dark:text-slate-300 mt-2">Catatan: {{ $permohonan->notes }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Dokumen Pendukung</p>
                            @if(!empty($docs))
                                <ul class="space-y-3">
                                    @foreach($docs as $field => $path)
                                        <li class="flex items-center justify-between gap-4 p-3 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <span class="material-symbols-outlined text-primary">description</span>
                                                <span class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $field }} — {{ basename($path) }}</span>
                                            </div>
                                            <a class="text-primary text-sm font-semibold hover:underline" target="_blank" href="{{ asset('storage/'.$path) }}">Lihat</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-4 px-3 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-dashed border-slate-300 dark:border-slate-700">
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Belum ada dokumen yang diunggah.</p>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Dokumen Hasil</p>
                            @php $hasil = is_array($permohonan->dokumen_json) ? ($permohonan->dokumen_json['hasil'] ?? []) : []; @endphp
                            @if(!empty($hasil))
                                <ul class="space-y-3">
                                    @foreach($hasil as $field => $path)
                                        <li class="flex items-center justify-between gap-4 p-3 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <span class="material-symbols-outlined text-primary">article</span>
                                                <span class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ ucwords(str_replace('_',' ', $field)) }}</span>
                                            </div>
                                            <a class="text-primary text-sm font-semibold hover:underline" target="_blank" href="{{ asset('storage/'.$path) }}">Unduh</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-4 px-3 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-dashed border-slate-300 dark:border-slate-700">
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Dokumen akan tersedia di sini setelah permohonan disetujui.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] px-6 py-4 border-b border-slate-200 dark:border-slate-700">Riwayat Status</h2>
                    <div class="p-6">
                        @php
                            // Lightweight timeline derived from timestamps and current status
                            $timeline = [];
                            $timeline[] = ['icon' => 'task_alt', 'label' => 'Permohonan Diajukan', 'time' => $permohonan->created_at];
                            if (in_array($status, ['processing','diproses'])) {
                                $timeline[] = ['icon' => 'visibility', 'label' => 'Sedang Diverifikasi', 'time' => $permohonan->updated_at];
                            }
                            if (in_array($status, ['approved','selesai'])) {
                                $timeline[] = ['icon' => 'check_circle', 'label' => 'Disetujui', 'time' => $permohonan->updated_at];
                            }
                            if (in_array($status, ['rejected','ditolak'])) {
                                $timeline[] = ['icon' => 'cancel', 'label' => 'Ditolak', 'time' => $permohonan->updated_at];
                            }
                            if (in_array($status, ['revisi','perlu revisi'])) {
                                $timeline[] = ['icon' => 'edit', 'label' => 'Perlu Revisi', 'time' => $permohonan->updated_at];
                            }
                        @endphp
                        <div class="relative">
                            <div class="absolute left-3 top-1 w-0.5 h-full bg-slate-200 dark:bg-slate-700"></div>
                            <ul class="space-y-8">
                                @foreach($timeline as $item)
                                    <li class="relative flex items-start gap-4">
                                        <div class="flex size-6 items-center justify-center rounded-full bg-primary text-white ring-8 ring-white dark:ring-slate-900/50">
                                            <span class="material-symbols-outlined text-base">{{ $item['icon'] }}</span>
                                        </div>
                                        <div class="flex-1 -mt-1">
                                            <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $item['label'] }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                <time title="{{ $item['time']->translatedFormat('d M Y H:i') }}" data-relative-time="{{ $item['time']->toIso8601String() }}">{{ $item['time']->format('Y-m-d H:i') }}</time>
                                            </p>
                                            @if($item['label'] === 'Perlu Revisi' && !empty($permohonan->notes))
                                                <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">Catatan: {{ $permohonan->notes }}</p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
