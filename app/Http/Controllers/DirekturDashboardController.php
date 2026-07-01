<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\PeriodePenilaian;
use App\Models\HasilPerhitungan;
use App\Models\ValidasiHasil;
use Illuminate\Support\Facades\Auth;

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

        $karyawanPerluValidasiCount = 0;
        if ($periode && $statusValidasi === 'menunggu') {
            $totalSubKriteria = \App\Models\SubKriteria::count();
            if ($totalSubKriteria > 0) {
                $karyawanIdsWithAssessments = \App\Models\Penilaian::where('periode_id', $periode->id)
                    ->select('karyawan_id')
                    ->groupBy('karyawan_id')
                    ->havingRaw('count(distinct sub_kriteria_id) >= ?', [$totalSubKriteria])
                    ->pluck('karyawan_id');
                
                $karyawanPerluValidasiCount = \App\Models\Karyawan::where('status', 'aktif')
                    ->whereIn('id', $karyawanIdsWithAssessments)
                    ->count();
            }
        }

        return view('direktur.dashboard', compact(
            'periode',
            'hasilList',
            'validasi',
            'statusValidasi',
            'karyawanPerluValidasiCount'
        ));
    }

    public function validasi()
    {
        $periode = PeriodePenilaian::where('status', 'aktif')->first();

        $hasilList = collect();
        $validasi = null;
        $karyawanTelahDinilai = collect();

        if ($periode) {
            $hasilList = HasilPerhitungan::with('karyawan')
                ->where('periode_id', $periode->id)
                ->orderBy('ranking', 'ASC')
                ->get();

            $validasi = ValidasiHasil::with('user')
                ->where('periode_id', $periode->id)
                ->first();

            $totalSubKriteria = \App\Models\SubKriteria::count();
            if ($totalSubKriteria > 0) {
                $karyawanIdsWithAssessments = \App\Models\Penilaian::where('periode_id', $periode->id)
                    ->select('karyawan_id')
                    ->groupBy('karyawan_id')
                    ->havingRaw('count(distinct sub_kriteria_id) >= ?', [$totalSubKriteria])
                    ->pluck('karyawan_id');
                
                $karyawanTelahDinilai = \App\Models\Karyawan::where('status', 'aktif')
                    ->whereIn('id', $karyawanIdsWithAssessments)
                    ->get();
            }
        }

        $statusValidasi = $validasi->status_validasi ?? 'menunggu';

        return view('direktur.validasi', compact(
            'periode',
            'hasilList',
            'validasi',
            'statusValidasi',
            'karyawanTelahDinilai'
        ));
    }
}