<?php

namespace App\Http\Controllers\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class AdminPermohonanController extends Controller
{
    public function index()
    {
        $permohonans = Permohonan::with('user')->latest()->paginate(20);
        return view('permohonan.admin.index', compact('permohonans'));
    }

    public function show(Permohonan $permohonan)
    {
        return view('permohonan.admin.show', compact('permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $data = $request->validate(['status' => 'required|in:pending,processing,approved,rejected']);
        $permohonan->update($data);
        return back()->with('status','Status permohonan diperbarui.');
    }
}
