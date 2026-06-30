<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\PeriodePenilaian;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Periode Aktif
        $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();

        // 2. Siapkan data statistik untuk kartu (card)
        $totalKaryawan = Karyawan::count();
        $totalKriteria = Kriteria::count();
        $totalPeriode = PeriodePenilaian::count();
        $totalPenilaian = Penilaian::count();

        // 3. Ambil data Top 5 Karyawan (hanya jika ada periode aktif)
        $topKaryawan = collect();
        $validasiAktif = null;
        if ($periodeAktif) {
            $topKaryawan = HasilPerhitungan::with('karyawan')
                ->where('periode_id', $periodeAktif->id)
                ->orderBy('ranking', 'ASC')
                ->limit(5)
                ->get();

            $validasiAktif = \App\Models\ValidasiHasil::with('user')
                ->where('periode_id', $periodeAktif->id)
                ->first();
        }

        // 4. Kirim semua variabel ke view
        return view('dashboard', compact(
            'periodeAktif', 
            'totalKaryawan', 
            'totalKriteria', 
            'totalPeriode', 
            'totalPenilaian', 
            'topKaryawan',
            'validasiAktif'
        ));
    }
}