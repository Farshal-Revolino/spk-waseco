<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\PeriodePenilaian;
use App\Models\HasilPerhitungan;
use App\Models\Penilaian;

class DashboardController extends Controller
{
    public function index()
    {
        $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();

        $totalKaryawan = Karyawan::where('status', 'aktif')->count();
        $totalKriteria = Kriteria::count();
        $totalPeriode = PeriodePenilaian::count();
        
        $totalPenilaian = 0;
        if ($periodeAktif) {
            $totalPenilaian = Penilaian::where('periode_id', $periodeAktif->id)
                ->distinct('karyawan_id')
                ->count('karyawan_id');
        }

        $topKaryawan = [];
        if ($periodeAktif) {
            $topKaryawan = HasilPerhitungan::with('karyawan')
                ->where('periode_id', $periodeAktif->id)
                ->orderBy('ranking', 'ASC')
                ->limit(5)
                ->get();
        }

        $chartKlasifikasi = [
            'labels' => ['A - Baik Sekali', 'B - Baik', 'C - Cukup', 'D - Kurang'],
            'data' => [0, 0, 0, 0]
        ];

        if ($periodeAktif) {
            $klasifikasiCount = HasilPerhitungan::where('periode_id', $periodeAktif->id)
                ->selectRaw('klasifikasi, count(*) as total')
                ->groupBy('klasifikasi')
                ->get()
                ->pluck('total', 'klasifikasi');

            $chartKlasifikasi['data'] = [
                $klasifikasiCount['A'] ?? 0,
                $klasifikasiCount['B'] ?? 0,
                $klasifikasiCount['C'] ?? 0,
                $klasifikasiCount['D'] ?? 0
            ];
        }

        return view('dashboard', compact(
            'totalKaryawan',
            'totalKriteria',
            'totalPeriode',
            'totalPenilaian',
            'topKaryawan',
            'periodeAktif',
            'chartKlasifikasi'
        ));
    }
}