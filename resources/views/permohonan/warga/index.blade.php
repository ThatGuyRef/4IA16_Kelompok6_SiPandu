<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto py-6">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl md:text-3xl font-black leading-tight tracking-[-0.03em]">Permohonan Saya</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Lacak dan kelola semua permohonan Anda di sini.</p>
            </div>
            <a href="{{ route('permohonan.warga.create') }}" class="inline-flex min-w-[84px] items-center justify-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-base font-bold leading-normal tracking-tight shadow-sm hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">Buat Permohonan Baru</span>
            </a>
        </div>

        @if(session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 mb-4">{{ session('status') }}</div>
        @endif

        @php
            $typeLabels = [
                'pembuatan_akta_kelahiran' => 'Permohonan Akta Kelahiran',
                'pembaruan_akta_kelahiran' => 'Pembaruan Akta Kelahiran',
                'akta_nikah_islam' => 'Permohonan Akta Nikah (Islam)',
                'akta_nikah_non_islam' => 'Permohonan Akta Nikah (Non-Islam)',
                'akta_kematian' => 'Permohonan Akta Kematian',
            ];

            function statusMeta($status) {
                $status = strtolower((string)$status);
                return match ($status) {
                    'approved', 'selesai' => ['label' => 'Selesai', 'bg' => 'bg-green-100 dark:bg-green-500/20', 'text' => 'text-green-800 dark:text-green-300', 'icon' => 'check_circle', 'progress' => 100],
                    'rejected', 'ditolak' => ['label' => 'Ditolak', 'bg' => 'bg-red-100 dark:bg-red-500/20', 'text' => 'text-red-800 dark:text-red-300', 'icon' => 'cancel', 'progress' => 100],
                    'processing', 'diproses' => ['label' => 'Diproses', 'bg' => 'bg-sky-100 dark:bg-sky-500/20', 'text' => 'text-sky-800 dark:text-sky-300', 'icon' => 'hourglass_top', 'progress' => 50],
                    default => ['label' => 'Menunggu', 'bg' => 'bg-amber-100 dark:bg-amber-500/20', 'text' => 'text-amber-800 dark:text-amber-300', 'icon' => 'hourglass_bottom', 'progress' => 25],
                };
            }
        @endphp

        @if($permohonans->count())
            <div class="flex flex-col gap-6">
                @foreach($permohonans as $p)
                    @php $meta = statusMeta($p->status); @endphp
                    <div class="flex flex-col gap-4 rounded-xl bg-white dark:bg-slate-800 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.05)] dark:shadow-none border border-transparent dark:border-slate-700">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex size-10 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700">
                                    <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">badge</span>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="text-base font-bold leading-tight text-slate-900 dark:text-white">{{ $typeLabels[$p->type] ?? ucwords(str_replace('_',' ', $p->type)) }}</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">ID #{{ $p->id }} • Diajukan: 
                                        <time data-relative-time="{{ $p->created_at->toIso8601String() }}" title="{{ $p->created_at->translatedFormat('d M Y H:i') }}">
                                            {{ $p->created_at->format('Y-m-d H:i') }}
                                        </time>
                                    </p>
                                </div>
                            </div>
                            <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium w-fit {{ $meta['bg'] }} {{ $meta['text'] }}">
                                <span class="material-symbols-outlined text-sm">{{ $meta['icon'] }}</span>
                                <span>{{ $meta['label'] }}</span>
                            </div>
                        </div>

                        @if(in_array(strtolower((string)$p->status), ['processing','diproses']))
                            <div class="flex flex-col gap-2">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Status: <span class="font-bold">Verifikasi Berkas oleh Petugas</span></p>
                                <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full js-progress" data-progress="{{ $meta['progress'] }}"></div>
                                </div>
                                <div class="flex justify-between text-xs text-slate-500 dark:text-slate-400">
                                    <span>Diajukan</span>
                                    <span>Verifikasi</span>
                                    <span>Pencetakan</span>
                                    <span>Selesai</span>
                                </div>
                            </div>
                        @endif

                        <div class="border-t border-slate-200 dark:border-slate-700 pt-4 flex justify-end">
                            <a class="text-sm font-medium text-primary hover:underline" href="{{ route('permohonan.warga.show', $p) }}">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
    @else
            <div class="mt-6">
                <div class="flex flex-col items-center justify-center text-center p-8 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800/50">
                    <span class="material-symbols-outlined text-5xl text-slate-400 dark:text-slate-500 mb-4">folder_off</span>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Belum Ada Permohonan</h3>
                    <p class="max-w-xs mt-1 text-sm text-slate-600 dark:text-slate-400">Anda belum pernah mengajukan permohonan. Mulai dengan menekan tombol di bawah ini.</p>
                    <a href="{{ route('permohonan.warga.create') }}" class="inline-flex mt-6 min-w-[84px] items-center justify-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-base font-bold leading-normal tracking-tight shadow-sm hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined">add</span>
                        <span class="truncate">Buat Permohonan Pertama</span>
                    </a>
                </div>
            </div>
        @endif
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.js-progress[data-progress]').forEach(function(el){
                    const p = parseInt(el.getAttribute('data-progress') || '0', 10);
                    if (!Number.isNaN(p)) {
                        el.style.width = Math.max(0, Math.min(100, p)) + '%';
                    }
                });
            });
        </script>
        @endpush
    </div>
</x-dashboard-layout>
