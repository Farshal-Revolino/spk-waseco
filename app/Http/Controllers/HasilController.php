<?php

namespace App\Http\Controllers;

use App\Models\PeriodePenilaian;
use App\Models\HasilPerhitungan;
use App\Models\Karyawan;
use App\Services\ProfileMatchingService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $periodeId = $request->get('periode_id');
        
        if (!$periodeId) {
            $periode = PeriodePenilaian::where('status', 'aktif')->first();
            $periodeId = $periode ? $periode->id : null;
        }

        $allPeriode = PeriodePenilaian::orderBy('tahun', 'DESC')->get();
        $periode = $periodeId ? PeriodePenilaian::find($periodeId) : null;

        $hasilList = [];
        if ($periode) {
            $hasilList = HasilPerhitungan::with('karyawan')
                ->where('periode_id', $periode->id)
                ->orderBy('ranking', 'ASC')
                ->get();
        }

        return view('hasil.index', compact('hasilList', 'periode', 'allPeriode'));
    }

    public function calculate(Request $request)
    {
        $periodeId = $request->get('periode_id');
        
        if (!$periodeId) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan');
        }

        $service = new ProfileMatchingService($periodeId);
        $result = $service->calculate();

        if ($result['success']) {
            return redirect()->route('hasil.index', ['periode_id' => $periodeId])
                ->with('success', $result['message']);
        } else {
            return redirect()->route('hasil.index', ['periode_id' => $periodeId])
                ->with('error', $result['message']);
        }
    }

    public function show($id, Request $request)
    {
        $periodeId = $request->get('periode_id');
        
        if (!$periodeId) {
            $periode = PeriodePenilaian::where('status', 'aktif')->first();
            $periodeId = $periode ? $periode->id : null;
        }

        if (!$periodeId) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan');
        }

        $service = new ProfileMatchingService($periodeId);
        $data = $service->getDetailPerhitungan($id);

        if (!$data) {
            return redirect()->route('hasil.index', ['periode_id' => $periodeId])
                ->with('error', 'Data perhitungan tidak ditemukan. Pastikan sudah melakukan proses perhitungan.');
        }

        return view('hasil.show', $data);
    }

    public function exportPDF(Request $request)
    {
        $periodeId = $request->get('periode_id');
        
        if (!$periodeId) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan');
        }

        $periode = PeriodePenilaian::find($periodeId);
        
        if (!$periode) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan');
        }

        $hasilList = HasilPerhitungan::with('karyawan')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking', 'ASC')
            ->get();

        if ($hasilList->isEmpty()) {
            return redirect()->route('hasil.index', ['periode_id' => $periodeId])
                ->with('error', 'Belum ada data hasil perhitungan untuk dicetak');
        }

        // Statistik
        $stats = [
            'total' => $hasilList->count(),
            'klasifikasi_a' => $hasilList->where('klasifikasi', 'A')->count(),
            'klasifikasi_b' => $hasilList->where('klasifikasi', 'B')->count(),
            'klasifikasi_c' => $hasilList->where('klasifikasi', 'C')->count(),
            'klasifikasi_d' => $hasilList->where('klasifikasi', 'D')->count(),
        ];

        $pdf = Pdf::loadView('hasil.pdf', [
            'hasilList' => $hasilList,
            'periode' => $periode,
            'stats' => $stats
        ]);

        $pdf->setPaper('a4', 'landscape');

        $namaFile = 'Laporan_Hasil_Penilaian_' . str_replace('/', '_', $periode->nama) . '.pdf';
        return $pdf->download($namaFile);
    }
}