<x-dashboard-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400" style="font-size:48px">check_circle</span>
            </div>
            <h1 class="text-[#0d141b] dark:text-white tracking-tight text-[32px] font-bold leading-tight pb-2">Permohonan Berhasil Diajukan!</h1>
            <p class="text-[#4c739a] dark:text-gray-400 text-base leading-normal pb-6 max-w-md">Terima kasih, permohonan Anda telah kami terima dan akan segera diproses.</p>
        </div>

        <div class="w-full bg-slate-50 dark:bg-background-dark border border-slate-200 dark:border-gray-700 rounded-xl shadow-sm p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-900/50 mb-6">
                <div class="flex-grow">
                    <p class="text-amber-800 dark:text-amber-200 text-lg font-bold leading-tight tracking-[-0.015em]">Nomor Referensi: {{ sprintf('PMN-%06d', $permohonan->id) }}</p>
                    <p class="text-amber-700 dark:text-amber-300 text-sm leading-normal mt-1">Simpan nomor referensi ini untuk melacak status permohonan Anda.</p>
                </div>
                <button type="button" id="copy-ref" data-ref="{{ sprintf('PMN-%06d', $permohonan->id) }}" class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-9 px-4 bg-amber-500 text-white text-sm font-medium hover:bg-amber-600">
                    <span class="material-symbols-outlined text-sm mr-2">content_copy</span>
                    <span class="truncate">Salin</span>
                </button>
            </div>

            <div class="grid grid-cols-[1fr_2fr] sm:grid-cols-[150px_1fr] gap-x-6 gap-y-4">
                <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#cfdbe7] dark:border-t-gray-700 pt-5">
                    <p class="text-[#4c739a] dark:text-gray-400 text-sm">Jenis Surat</p>
                    <p class="text-[#0d141b] dark:text-white text-sm font-medium">{{ ucwords(str_replace(['_','-'],' ', $permohonan->type)) }}</p>
                </div>
                <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#cfdbe7] dark:border-t-gray-700 py-5">
                    <p class="text-[#4c739a] dark:text-gray-400 text-sm">Pemohon</p>
                    <p class="text-[#0d141b] dark:text-white text-sm font-medium">{{ $permohonan->nama ?? optional($permohonan->user)->name }}</p>
                </div>
                <div class="col-span-2 grid grid-cols-subgrid border-t border-t-[#cfdbe7] dark:border-t-gray-700 py-5">
                    <p class="text-[#4c739a] dark:text-gray-400 text-sm">Tanggal Pengajuan</p>
                    <p class="text-[#0d141b] dark:text-white text-sm font-medium">
                        <time data-relative-time="{{ $permohonan->created_at->toIso8601String() }}" title="{{ $permohonan->created_at->format('d M Y H:i') }}">{{ $permohonan->created_at->format('d M Y') }}</time>
                    </p>
                </div>
                <div class="col-span-2 border-t border-t-[#cfdbe7] dark:border-t-gray-700 pt-5">
                    <p class="text-[#4c739a] dark:text-gray-400 text-sm mb-2">Langkah Selanjutnya</p>
                    <p class="text-[#0d141b] dark:text-white text-sm leading-relaxed">Status permohonan akan kami informasikan melalui notifikasi di dashboard. Silakan periksa secara berkala.</p>
                </div>
            </div>
        </div>

        <div class="w-full bg-primary/10 dark:bg-primary/20 border border-primary/20 dark:border-primary/30 rounded-xl p-6 mt-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex-grow text-center sm:text-left">
                    <h2 class="text-primary dark:text-primary-200 text-lg font-bold">Lacak Status Permohonan Anda</h2>
                    <p class="text-primary/80 dark:text-primary-200/80 text-sm mt-1">Lihat perkembangan terbaru dari permohonan Anda.</p>
                </div>
                <a href="{{ route('permohonan.warga.index') }}" class="flex w-full sm:w-auto items-center justify-center rounded-lg h-11 px-6 bg-primary text-white font-bold hover:bg-primary/90">
                    <span class="truncate">Lihat Status Permohonan</span>
                    <span class="material-symbols-outlined ml-2">arrow_forward</span>
                </a>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8 w-full">
            <a href="{{ route('dashboard') }}" class="flex w-full sm:w-auto items-center justify-center rounded-lg h-11 px-6 bg-slate-200 dark:bg-gray-700 text-[#0d141b] dark:text-white text-base font-medium hover:bg-slate-300 dark:hover:bg-gray-600">Kembali ke Dashboard</a>
            <button type="button" onclick="window.print()" class="flex w-full sm:w-auto items-center justify-center rounded-lg h-11 px-6 bg-slate-200 dark:bg-gray-700 text-[#0d141b] dark:text-white text-base font-medium hover:bg-slate-300 dark:hover:bg-gray-600">Cetak Bukti Pengajuan</button>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('copy-ref');
            if (btn) {
                btn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(btn.dataset.ref);
                        btn.innerHTML = '<span class="material-symbols-outlined text-sm mr-2">check</span><span>Tersalin</span>';
                        setTimeout(function(){ window.location.href = "{{ route('permohonan.warga.index') }}"; }, 800);
                    } catch (e) {}
                });
            }
        });
    </script>
    @endpush
</x-dashboard-layout>
