<x-dashboard-layout>
    @php
        $user = auth()->user();
        $myBase = \App\Models\Permohonan::where('user_id', optional($user)->id);
        $processingCount = (clone $myBase)->whereIn('status', ['pending','processing'])->count();
        $approvedCount = (clone $myBase)->where('status','approved')->count();
        $notifCount = (clone $myBase)->where('updated_at','>=', now()->subDay())->count();
        $recent = (clone $myBase)->with('user')->latest()->limit(5)->get();
    @endphp

    <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto py-6">
        <h1 class="text-[#0d141b] dark:text-slate-50 tracking-light text-[32px] font-bold leading-tight">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6 border border-[#cfdbe7] dark:border-gray-700 bg-white dark:bg-[#182430]">
                <p class="text-[#0d141b] dark:text-slate-50 text-base font-medium leading-normal">Permohonan Diproses</p>
                <p class="text-[#0d141b] dark:text-slate-50 tracking-light text-3xl font-bold leading-tight">{{ number_format($processingCount) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6 border border-[#cfdbe7] dark:border-gray-700 bg-white dark:bg-[#182430]">
                <p class="text-[#0d141b] dark:text-slate-50 text-base font-medium leading-normal">Permohonan Selesai</p>
                <p class="text-[#0d141b] dark:text-slate-50 tracking-light text-3xl font-bold leading-tight">{{ number_format($approvedCount) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6 border border-[#cfdbe7] dark:border-gray-700 bg-white dark:bg-[#182430]">
                <p class="text-[#0d141b] dark:text-slate-50 text-base font-medium leading-normal">Pemberitahuan Baru</p>
                <p class="text-[#0d141b] dark:text-slate-50 tracking-light text-3xl font-bold leading-tight">{{ number_format($notifCount) }}</p>
            </div>
        </div>

        @if(optional($user)->role === 'warga')
            <div class="mt-6">
                <a href="{{ route('permohonan.warga.create') }}" class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-16 px-6 bg-primary text-white text-lg font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                    <span class="truncate">Ajukan Surat Permohonan Baru</span>
                    <span class="material-symbols-outlined ml-2">arrow_forward</span>
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <div class="lg:col-span-2 bg-white dark:bg-[#182430] p-6 rounded-lg border border-[#cfdbe7] dark:border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-[#0d141b] dark:text-slate-50 text-xl font-bold leading-tight">Riwayat Permohonan</h2>
                    <a class="text-sm font-medium text-primary hover:underline" href="{{ route('permohonan.warga.index') }}">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                        <tr class="border-b dark:border-gray-700">
                            <th class="py-3 px-4 font-semibold text-sm">Jenis Surat</th>
                            <th class="py-3 px-4 font-semibold text-sm">Tanggal Pengajuan</th>
                            <th class="py-3 px-4 font-semibold text-sm">Status</th>
                            <th class="py-3 px-4 font-semibold text-sm text-right">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recent as $p)
                            @php
                                $status = strtolower($p->status ?? 'pending');
                                $badge = match($status){
                                    'approved' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-blue-100 text-blue-800',
                                    'processing' => 'bg-yellow-100 text-yellow-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <tr class="border-b dark:border-gray-700">
                                <td class="py-3 px-4 text-sm">{{ ucwords(str_replace(['_','-'],' ', $p->type ?? '—')) }}</td>
                                <td class="py-3 px-4 text-sm">
                                    <time data-relative-time="{{ optional($p->created_at)->toIso8601String() }}" title="{{ optional($p->created_at)->format('d M Y H:i') }}">
                                        {{ optional($p->created_at)->format('d M Y') }}
                                    </time>
                                </td>
                                <td class="py-3 px-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td class="py-3 px-4 text-sm text-right">
                                    <a href="{{ route('permohonan.warga.index') }}" class="text-primary hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 px-4 text-center text-sm text-gray-500">Belum ada permohonan.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-[#182430] p-6 rounded-lg border border-[#cfdbe7] dark:border-gray-700">
                <h2 class="text-[#0d141b] dark:text-slate-50 text-xl font-bold leading-tight mb-4">Informasi &amp; Pengumuman</h2>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-1">campaign</span>
                        <div>
                            <p class="font-medium">Jadwal Pelayanan</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Cek jam layanan terkini di kelurahan.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-1">info</span>
                        <div>
                            <p class="font-medium">Pembaruan Sistem</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Fitur baru untuk kemudahan pengajuan online.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-dashboard-layout>
