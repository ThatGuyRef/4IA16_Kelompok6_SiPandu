<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Buat Permohonan Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('permohonan.warga.store') }}" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Jenis Permohonan</label>
                        <select name="type" class="form-control" id="jenis-permohonan" data-old="{{ old('type') }}">
                            <option value="pembuatan_akta_kelahiran" {{ old('type')=='pembuatan_akta_kelahiran' ? 'selected' : '' }}>Pembuatan Akta Kelahiran</option>
                            <option value="pembaruan_akta_kelahiran" {{ old('type')=='pembaruan_akta_kelahiran' ? 'selected' : '' }}>Pembaruan Akta Kelahiran</option>
                            <option value="akta_nikah_islam" {{ old('type')=='akta_nikah_islam' ? 'selected' : '' }}>Akta Nikah (Islam)</option>
                            <option value="akta_nikah_non_islam" {{ old('type')=='akta_nikah_non_islam' ? 'selected' : '' }}>Akta Nikah (Non-Islam)</option>
                            <option value="akta_kematian" {{ old('type')=='akta_kematian' ? 'selected' : '' }}>Akta Kematian</option>
                        </select>
                    </div>


                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK</label>
                            <input name="nik" type="text" class="form-control" maxlength="16" pattern="\d{16}" inputmode="numeric" placeholder="16 digit NIK" value="{{ old('nik', auth()->check() ? auth()->user()->nik : '') }}">
                            <small class="form-text text-muted">Masukkan 16 digit NIK (jika tidak diisi, sistem akan gunakan NIK akun Anda).</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input name="nama" type="text" class="form-control" maxlength="191" placeholder="Nama lengkap" value="{{ old('nama', auth()->check() ? auth()->user()->name : '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap (jalan, RT/RW, desa/kelurahan)">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input name="phone" type="tel" class="form-control" inputmode="tel" placeholder="0812xxxxxxx" value="{{ old('phone', auth()->check() ? auth()->user()->phone ?? '' : '') }}">
                    </div>

                    <!-- area untuk menampilkan input file yang relevan (pindah ke akhir form) -->
                    <div id="upload-dokumen" class="mb-3"></div>

                    <button class="btn btn-primary" type="submit">Kirim Permohonan</button>

                    @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const sel = document.getElementById('jenis-permohonan');
                            const uploadBox = document.getElementById('upload-dokumen');
                            const templates = {
                                'pembuatan_akta_kelahiran': `<div class='mb-2'><label class='form-label'>Dokumen untuk Pembuatan Akta Kelahiran</label><div class='mb-2'><label class='form-label small'>Surat Kelahiran <span class='text-danger'>*</span></label><input type='file' name='documents[pembuatan_akta_kelahiran][surat_kelahiran]' class='form-control' accept='image/*,application/pdf' required></div></div>`,
                                'pembaruan_akta_kelahiran': `<div class='mb-2'><label class='form-label'>Dokumen untuk Pembaruan Akta Kelahiran</label><div class='mb-2'><label class='form-label small'>Akta Kelahiran Lama <span class='text-danger'>*</span></label><input type='file' name='documents[pembaruan_akta_kelahiran][akta_lama]' class='form-control' accept='image/*,application/pdf' required></div></div>`,
                                'akta_nikah_islam': `<div class='mb-2'><label class='form-label'>Dokumen untuk Akta Nikah (Islam)</label><div class='mb-2'><label class='form-label small'>Buku Nikah <span class='text-danger'>*</span></label><input type='file' name='documents[akta_nikah_islam][buku_nikah]' class='form-control' accept='image/*,application/pdf' required></div></div>`,
                                'akta_nikah_non_islam': `<div class='mb-2'><label class='form-label'>Dokumen untuk Akta Nikah (Non-Islam)</label><div class='mb-2'><label class='form-label small'>Akta Nikah <span class='text-danger'>*</span></label><input type='file' name='documents[akta_nikah_non_islam][akta_nikah]' class='form-control' accept='image/*,application/pdf' required></div></div>`,
                                'akta_kematian': `<div class='mb-2'><label class='form-label'>Dokumen untuk Akta Kematian</label><div class='mb-2'><label class='form-label small'>Surat Keterangan Kematian <span class='text-danger'>*</span></label><input type='file' name='documents[akta_kematian][surat_keterangan_kematian]' class='form-control' accept='image/*,application/pdf' required></div></div>`,
                            };
                            function renderInput() {
                                const type = sel.value;
                                uploadBox.innerHTML = templates[type] || '';
                            }
                            sel.addEventListener('change', renderInput);
                            // Initialize
                            renderInput();
                        });
                    </script>
                    @endpush
                </form>
            </div>
        </div>
    </div>
</x-app-layout>