<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\PeriodePenilaian;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();
        $allPeriode = PeriodePenilaian::orderBy('tahun', 'DESC')->get();
        
        $karyawanList = [];
        
        if ($periodeAktif) {
            $karyawanList = Karyawan::where('status', 'aktif')->get()->map(function($karyawan) use ($periodeAktif) {
                $totalSubKriteria = SubKriteria::count();
                $totalPenilaian = Penilaian::where('karyawan_id', $karyawan->id)
                    ->where('periode_id', $periodeAktif->id)
                    ->count();
                
                $karyawan->progress = $totalSubKriteria > 0 ? round(($totalPenilaian / $totalSubKriteria) * 100) : 0;
                $karyawan->is_complete = $totalPenilaian >= $totalSubKriteria;
                
                return $karyawan;
            });
        }

        return view('penilaian.index', compact('periodeAktif', 'allPeriode', 'karyawanList'));
    }

    public function create(Request $request)
    {
        $karyawanId = $request->get('karyawan_id');
        $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Tidak ada periode penilaian aktif');
        }

        $karyawan = Karyawan::findOrFail($karyawanId);
        
        $kriteriaList = Kriteria::with(['subKriteria.profilIdeal'])
            ->orderBy('urutan')
            ->get();

        $existingPenilaian = Penilaian::where('karyawan_id', $karyawanId)
            ->where('periode_id', $periodeAktif->id)
            ->get()
            ->keyBy('sub_kriteria_id');

        $isReadOnly = ($periodeAktif->status_validasi === 'divalidasi');

        return view('penilaian.create', compact('karyawan', 'kriteriaList', 'periodeAktif', 'existingPenilaian', 'isReadOnly'));
    }

    public function store(Request $request)
    {
        $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Tidak ada periode penilaian aktif');
        }

        if ($periodeAktif->status_validasi === 'divalidasi') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Penilaian tidak dapat diubah karena laporan periode aktif sudah disetujui/divalidasi oleh Direktur.');
        }

        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'penilaian' => 'required|array',
            'penilaian.*' => 'required|integer|min:0|max:20'
        ]);

        $karyawanId = $request->karyawan_id;
        $penilaianData = $request->penilaian;

        foreach ($penilaianData as $subKriteriaId => $nilai) {
            Penilaian::updateOrCreate(
                [
                    'karyawan_id' => $karyawanId,
                    'sub_kriteria_id' => $subKriteriaId,
                    'periode_id' => $periodeAktif->id
                ],
                ['nilai' => $nilai]
            );
        }

        // Reset status validasi dan hapus data kalkulasi lama karena nilai penilaian telah berubah
        \App\Models\ValidasiHasil::where('periode_id', $periodeAktif->id)->delete();
        \App\Models\HasilPerhitungan::where('periode_id', $periodeAktif->id)->delete();
        $periodeAktif->update([
            'status_validasi' => 'menunggu'
        ]);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    public function show(string $id)
    {
        return redirect()->route('penilaian.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('penilaian.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('penilaian.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('penilaian.index');
    }
}