<?php

namespace App\Http\Controllers\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaPermohonanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $permohonans = Permohonan::where('user_id', $user->id)->latest()->get();
        return view('permohonan.warga.index', compact('permohonans'));
    }

    public function create()
    {
        return view('permohonan.warga.create');
    }

    public function store(Request $request)
    {
        $allowed = [
            'pembuatan_akta_kelahiran',
            'pembaruan_akta_kelahiran',
            'akta_nikah_islam',
            'akta_nikah_non_islam',
            'akta_kematian',
        ];

        $rules = [
            'type' => ['required','in:'.implode(',', $allowed)],
            'notes' => ['nullable','string'],
            'nik' => ['nullable','digits:16'],
            'nama' => ['nullable','string','max:191'],
            'alamat' => ['nullable','string'],
            'phone' => ['nullable','string','max:32'],
            // documents is an array keyed by type, each entry can be an array of files
        ];

        // Define fields per type and which are required
        $fieldsPerType = [
            'pembuatan_akta_kelahiran' => [
                'surat_kelahiran' => true,
            ],
            'pembaruan_akta_kelahiran' => [
                'akta_lama' => true,
            ],
            'akta_nikah_islam' => [
                'buku_nikah' => true,
            ],
            'akta_nikah_non_islam' => [
                'akta_nikah' => true,
            ],
            'akta_kematian' => [
                'surat_keterangan_kematian' => true,
            ],
        ];

        $selectedType = $request->input('type');

        // If the authenticated user is a warga, phone is required
        if (Auth::check() && Auth::user()->role === 'warga') {
            $rules['phone'] = ['required','string','max:32'];
        }

        // Add validation rules for each possible document field
        foreach ($fieldsPerType as $typeKey => $fields) {
            foreach ($fields as $fieldKey => $isRequired) {
                $ruleKey = sprintf('documents.%s.%s', $typeKey, $fieldKey);
                $rule = ['file','mimes:jpg,jpeg,png,pdf','max:5120'];
                // if this is the selected type and the field is required, add required rule
                if ($selectedType === $typeKey && $isRequired) {
                    array_unshift($rule, 'required');
                } else {
                    // make it nullable otherwise
                    array_unshift($rule, 'nullable');
                }
                $rules[$ruleKey] = $rule;
            }
        }

        // additional per-type required checks can be added here if needed

        $data = $request->validate($rules);

        $data['user_id'] = Auth::id();

        // Maintain backwards-compatible DB column 'jenis_keperluan'
        if (! empty($selectedType)) {
            $data['jenis_keperluan'] = $selectedType;
        }

        // prefer user nik if not provided in form
        if (empty($data['nik']) && Auth::user() && ! empty(Auth::user()->nik)) {
            $data['nik'] = Auth::user()->nik;
        }
        if (empty($data['nama']) && Auth::user() && ! empty(Auth::user()->name)) {
            $data['nama'] = Auth::user()->name;
        }

        $dokumen = [];
        if ($request->has('documents') && is_array($request->documents)) {
            foreach ($request->documents as $typeKey => $fields) {
                if (! is_array($fields)) continue;
                foreach ($fields as $fieldKey => $file) {
                    if (! $file instanceof \Illuminate\Http\UploadedFile) continue;
                    if (! $file->isValid()) continue;
                    $path = $file->storePublicly('permohonans/'.Auth::id()."/".$typeKey."/".$fieldKey, ['disk' => 'public']);
                    $dokumen[$typeKey][$fieldKey] = $path;
                }
            }
        }

        $data['dokumen_json'] = $dokumen ?: null;

        $permohonan = Permohonan::create($data);

        // Redirect to confirmation page
        return redirect()->route('permohonan.warga.confirm', $permohonan);
    }

    /**
     * Show confirmation screen for last or specific submission
     */
    public function confirm(?Permohonan $permohonan = null)
    {
        $user = Auth::user();
        if (!$permohonan) {
            $permohonan = Permohonan::where('user_id', $user->id)->latest()->first();
        }
        if (!$permohonan || $permohonan->user_id !== $user->id) {
            abort(404);
        }

        return view('permohonan.warga.confirm', [
            'permohonan' => $permohonan,
        ]);
    }

    /**
     * Show detail of a specific permohonan for the authenticated warga
     */
    public function show(Permohonan $permohonan)
    {
        $user = Auth::user();
        if (!$permohonan || $permohonan->user_id !== $user->id) {
            abort(404);
        }

        return view('permohonan.warga.show', [
            'permohonan' => $permohonan,
        ]);
    }
}
