<?php

namespace App\Http\Controllers;

use App\Models\ValidasiHasil;
use App\Models\PeriodePenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiHasilController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'periode_id'       => 'required|exists:periode_penilaian,id',
            'status_validasi'  => 'required|in:disetujui,ditolak', 
            'catatan_validasi' => 'required_if:status_validasi,ditolak|nullable|string',
        ]);

        ValidasiHasil::updateOrCreate(
            ['periode_id' => $request->periode_id],
            [
                'user_id'          => Auth::id(),
                'status_validasi'  => $request->status_validasi,
                'catatan_validasi' => $request->catatan_validasi,
                'tanggal_validasi' => now(),
            ]
        );

        $status_untuk_db = ($request->status_validasi === 'disetujui') ? 'divalidasi' : 'ditolak';

        PeriodePenilaian::where('id', $request->periode_id)->update([
            'status_validasi' => $status_untuk_db
        ]);

        return redirect()->route('direktur.dashboard')->with('success', 'Keputusan berhasil disimpan.');
    }
}