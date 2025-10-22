<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Permohonan #'.$permohonan->id) }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="card mb-3 p-3">
                    <p><strong>User:</strong> {{ $permohonan->user->name }} ({{ $permohonan->user->nik }})</p>
                    <p><strong>Jenis:</strong> {{ $permohonan->type }}</p>
                    <p><strong>Catatan:</strong><br>{{ $permohonan->notes }}</p>
                    <p><strong>Status:</strong> {{ $permohonan->status }}</p>
                </div>

                @php
                    $dokumen = $permohonan->dokumen_json ?? [];
                    $typeLabels = [
                        'pembuatan_akta_kelahiran' => 'Pembuatan Akta Kelahiran',
                        'pembaruan_akta_kelahiran' => 'Pembaruan Akta Kelahiran',
                        'akta_nikah_islam' => 'Akta Nikah (Islam)',
                        'akta_nikah_non_islam' => 'Akta Nikah (Non-Islam)',
                        'akta_kematian' => 'Akta Kematian',
                    ];
                    $fieldLabels = [
                        'surat_kelahiran' => 'Surat Kelahiran',
                        'akta_lama' => 'Akta Kelahiran Lama',
                        'buku_nikah' => 'Buku Nikah',
                        'akta_nikah' => 'Akta Nikah',
                        'surat_keterangan_kematian' => 'Surat Keterangan Kematian',
                    ];
                @endphp

                @if($dokumen && is_array($dokumen))
                    <div class="mb-4">
                        <h5 class="mb-2 font-semibold">Dokumen Ter-upload</h5>
                        @foreach($dokumen as $type => $fields)
                            <div class="mb-2 p-2 border rounded">
                                <div class="fw-bold mb-1">{{ $typeLabels[$type] ?? $type }}</div>
                                <ul class="mb-0 ps-3">
                                    @foreach($fields as $field => $path)
                                        <li>
                                            <span>{{ $fieldLabels[$field] ?? $field }}:</span>
                                            @php
                                                $url = $path ? asset('storage/'.$path) : null;
                                            @endphp
                                            @if($url)
                                                @if(preg_match('/\.(jpg|jpeg|png)$/i', $url))
                                                    <a href="{{ $url }}" target="_blank"><img src="{{ $url }}" alt="{{ $field }}" style="max-width:120px;max-height:120px;object-fit:cover;border:1px solid #ccc;padding:2px;"></a>
                                                    <a href="{{ $url }}" download class="btn btn-sm btn-outline-secondary ms-2">Download</a>
                                                @elseif(preg_match('/\.pdf$/i', $url))
                                                    <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat PDF</a>
                                                    <a href="{{ $url }}" download class="btn btn-sm btn-outline-secondary ms-2">Download</a>
                                                @else
                                                    <a href="{{ $url }}" target="_blank">Lihat File</a>
                                                @endif
                                            @else
                                                <span class="text-danger">(tidak ditemukan)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.permohonan.update', $permohonan) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Ubah Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $permohonan->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="processing" {{ $permohonan->status=='processing'?'selected':'' }}>Processing</option>
                            <option value="approved" {{ $permohonan->status=='approved'?'selected':'' }}>Approved</option>
                            <option value="rejected" {{ $permohonan->status=='rejected'?'selected':'' }}>Rejected</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
