<?php

namespace App\Http\Controllers\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class AdminPermohonanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permohonan::with('user')->latest();

        $q = trim((string) $request->get('q', ''));
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%")
                          ->orWhere('nik', 'like', "%{$q}%");
                    });
            });
        }

        $status = $request->get('status');
        if ($status && in_array($status, ['pending','processing','approved','rejected'])) {
            $query->where('status', $status);
        }

        $type = $request->get('type');
        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        $permohonans = $query->paginate(10)->withQueryString();
        $types = Permohonan::select('type')->distinct()->orderBy('type')->pluck('type')->filter()->values();

        return view('permohonan.admin.index', compact('permohonans','types','q','status','type'));
    }

    public function show(Permohonan $permohonan)
    {
        return view('permohonan.admin.show', compact('permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,approved,rejected',
            'notes' => 'nullable|string|max:2000',
            'result_label' => 'nullable|string|max:191',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $originalStatus = $permohonan->status;
        $permohonan->update([
            'status' => $data['status'],
            'notes' => $data['notes'] ?? $permohonan->notes,
        ]);

        // Handle optional upload of result document for warga
        if ($request->hasFile('result_file') && $request->file('result_file')->isValid()) {
            $file = $request->file('result_file');
            $path = $file->storePublicly('permohonans/results/'.$permohonan->id, ['disk' => 'public']);

            $dok = is_array($permohonan->dokumen_json) ? $permohonan->dokumen_json : [];
            if (!isset($dok['hasil']) || !is_array($dok['hasil'])) {
                $dok['hasil'] = [];
            }

            $label = trim((string)($data['result_label'] ?? 'Dokumen Hasil'));
            // generate a safe key
            $base = $label !== '' ? $label : 'dokumen_hasil';
            $key = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $base));
            try { $rand = substr(bin2hex(random_bytes(2)), 0, 4); } catch (\Throwable $e) { $rand = (string) random_int(1000,9999); }
            $fieldKey = trim($key, '_') . '_' . $rand;

            $dok['hasil'][$fieldKey] = $path;
            $permohonan->dokumen_json = $dok;
            $permohonan->save();
        }

        try {
            if (($data['status'] ?? null) === 'approved' && $originalStatus !== 'approved') {
                $wa = app(WhatsAppService::class);
                $name = $permohonan->nama ?: optional($permohonan->user)->name ?: 'Pemohon';
                $type = ucwords(str_replace(['_','-'], ' ', $permohonan->type ?? 'pengajuan'));
                $ref = '#' . $permohonan->id;
                $detailUrl = route('permohonan.warga.show', $permohonan);
                $printUrl = route('permohonan.warga.print', $permohonan);
                $message = "Halo {$name}, permohonan {$type} Anda dengan nomor referensi {$ref} telah DISETUJUI.\n\nDetail: {$detailUrl}\nCetak Bukti: {$printUrl}\n\nTerima kasih.";
                $wa->sendMessage($permohonan->phone, $message);
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim WhatsApp notifikasi persetujuan', [
                'permohonan_id' => $permohonan->id,
                'error' => $e->getMessage(),
            ]);
        }

        return back()->with('status','Status permohonan diperbarui.');
    }
}
