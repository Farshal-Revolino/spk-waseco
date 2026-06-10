<?php

namespace App\Http\Controllers;

use App\Models\ValidasiHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiHasilController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode_penilaian,id',
            'status_validasi' => 'required|in:disetujui,ditolak',
            'catatan_validasi' => 'nullable|string|max:1000',
        ]);

        ValidasiHasil::updateOrCreate(
            [
                'periode_id' => $request->periode_id,
            ],
            [
                'user_id' => Auth::id(),
                'status_validasi' => $request->status_validasi,
                'catatan_validasi' => $request->catatan_validasi,
                'tanggal_validasi' => now(),
            ]
        );

        $pesan = $request->status_validasi === 'disetujui'
            ? 'Hasil penilaian berhasil disetujui.'
            : 'Hasil penilaian berhasil ditolak.';

        return redirect()
            ->route('direktur.dashboard')
            ->with('success', $pesan);
    }
}