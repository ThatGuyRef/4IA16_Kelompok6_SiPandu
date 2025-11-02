<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        // Aggregate metrics for the dashboard (initial values; view will refresh these via polling)
        $totalWarga = User::where('role', 'warga')->count();
        $processingCount = Permohonan::where('status', 'processing')->count();
        $approvedCount = Permohonan::where('status', 'approved')->count();
        $pendingCount = Permohonan::where('status', 'pending')->count();
        $totalPermohonanThisMonth = Permohonan::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
        $jenisSuratTersedia = Permohonan::select('type')->distinct()->count();
        $recentPermohonans = Permohonan::with('user')->latest()->limit(8)->get();

        // Determine section and optionally load inline permohonan list or detail
        $section = $request->query('section');
        $permohonans = null;
        $permohonan = null;
        if ($section === 'permohonan') {
            $permohonans = Permohonan::with('user')->latest()->paginate(15);
        } elseif ($section === 'detail') {
            $id = $request->query('id');
            if ($id) {
                $permohonan = Permohonan::with('user')->findOrFail($id);
            }
        }

        return view('admin.dashboard', [
            'totalWarga'      => $totalWarga,
            'processingCount' => $processingCount,
            'approvedCount'   => $approvedCount,
            'pendingCount'    => $pendingCount,
            'totalPermohonanThisMonth' => $totalPermohonanThisMonth,
            'jenisSuratTersedia' => $jenisSuratTersedia,
            'recentPermohonans' => $recentPermohonans,
            'permohonans'     => $permohonans,
            'permohonan'      => $permohonan,
        ]);
    }

    public function permohonan(Request $request)
    {
        $request->merge(['section' => 'permohonan']);
        return $this->index($request);
    }

    public function show(Request $request, Permohonan $permohonan)
    {
        $request->merge(['section' => 'detail', 'id' => $permohonan->id]);
        return $this->index($request);
    }

    /**
     * Return live metrics for dashboard polling.
     */
    public function metrics(Request $request)
    {
        return response()->json([
            'totalWarga'      => User::where('role', 'warga')->count(),
            'processingCount' => Permohonan::where('status', 'processing')->count(),
            'approvedCount'   => Permohonan::where('status', 'approved')->count(),
            'pendingCount'    => Permohonan::where('status', 'pending')->count(),
        ]);
    }
}
