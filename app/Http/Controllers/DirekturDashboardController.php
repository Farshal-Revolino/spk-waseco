<?php

namespace App\Http\Controllers;

use App\Models\PeriodePenilaian;
use App\Models\HasilPerhitungan;
use App\Models\ValidasiHasil;

class DirekturDashboardController extends Controller
{
    public function index()
    {
        $periode = PeriodePenilaian::where('status', 'aktif')->first();

        $hasilList = collect();
        $validasi = null;

        if ($periode) {
            $hasilList = HasilPerhitungan::with('karyawan')
                ->where('periode_id', $periode->id)
                ->orderBy('ranking', 'ASC')
                ->get();

            $validasi = ValidasiHasil::with('user')
                ->where('periode_id', $periode->id)
                ->first();
        }

        $statusValidasi = $validasi->status_validasi ?? 'menunggu';

        return view('direktur.dashboard', compact(
            'periode',
            'hasilList',
            'validasi',
            'statusValidasi'
        ));
    }
}