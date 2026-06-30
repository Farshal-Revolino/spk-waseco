<?php

namespace App\Http\Controllers;
use App\Models\PeriodePenilaian;
use App\Models\ValidasiHasil;
use App\Models\HasilPerhitungan;
use App\Services\ProfileMatchingService;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    /**
     * Menampilkan halaman indeks hasil kalkulasi.
     */
    public function index(Request $request)
    {
        $periodeId = $request->input('periode_id');

        // Jika tidak ada parameter periode_id, coba cari yang aktif otomatis
        if (!$periodeId) {
            $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();
            $periodeId = $periodeAktif ? $periodeAktif->id : null;
        }

        // SINKRONISASI BLADE: Gunakan nama variabel $allPeriode sesuai di Blade Anda
        $allPeriode = PeriodePenilaian::orderBy('created_at', 'desc')->get();
        $periodeTerpilih = $periodeId ? PeriodePenilaian::find($periodeId) : null;

        $validasi = null;
        $statusValidasi = 'menunggu';
        $hasilList = collect();
        $hasData = false; // Default awal data dianggap kosong

        if ($periodeTerpilih) {
            $validasi = ValidasiHasil::with('user')
                ->where('periode_id', $periodeTerpilih->id)
                ->first();

            $statusValidasi = $validasi ? $validasi->status_validasi : 'menunggu';

            $hasilList = HasilPerhitungan::with('karyawan')
                ->where('periode_id', $periodeTerpilih->id)
                ->orderBy('ranking', 'ASC')
                ->get();
            
            // Jika hasilList tidak kosong, set $hasData menjadi true
            $hasData = $hasilList->isNotEmpty();
        }

        // Ambil role user yang sedang login untuk variabel $role di Blade
        $role = auth()->user()->role;

        return view('hasil.index', [
            'allPeriode' => $allPeriode,       // Mengatasi error @foreach($allPeriode)
            'periode' => $periodeTerpilih,     // Mengatasi error @if($periode)
            'hasilList' => $hasilList,
            'validasi' => $validasi,
            'statusValidasi' => $statusValidasi,
            'role' => $role,                   // Mengatasi error $role === 'admin'
            'hasData' => $hasData,             // Mengatasi error !$hasData
        ]);
    }

    /**
     * Memproses kalkulasi metode Profile Matching.
     */
    public function calculate(Request $request)
    {
        $periodeId = $request->input('periode_id');

        if (!$periodeId) {
            return redirect()->route('hasil.index')
                ->with('error', 'Pilih periode terlebih dahulu.');
        }

        $service = new ProfileMatchingService($periodeId);
        $result = $service->calculate();

        if ($result['success']) {
            // Hapus log validasi lama dan reset status validasi periode menjadi 'menunggu'
            \App\Models\ValidasiHasil::where('periode_id', $periodeId)->delete();
            \App\Models\PeriodePenilaian::where('id', $periodeId)->update([
                'status_validasi' => 'menunggu'
            ]);

            return redirect()->route('hasil.index', [
                'periode_id' => $periodeId
            ])->with('success', $result['message']);
        }

        return redirect()->route('hasil.index', [
            'periode_id' => $periodeId
        ])->with('error', $result['message']);
    }

    /**
     * Menampilkan detail perhitungan per karyawan dengan proteksi URL.
     */
    public function show($id, Request $request)
    {
        // 1. Ambil periode_id dari query string
        $periodeId = $request->input('periode_id'); 

        // 2. Jika tidak ada di URL, coba cari periode yang berstatus aktif otomatis
        if (!$periodeId) {
            $periodeAktif = PeriodePenilaian::where('status', 'aktif')->first();
            $periodeId = $periodeAktif ? $periodeAktif->id : null;
        }

        // 3. Validasi dini: Jika setelah dicari tetap tidak ada, balikkan ke indeks
        if (!$periodeId) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan atau parameter tidak valid.');
        }

        // 4. Cek status validasi berdasarkan periode_id
        $validasi = ValidasiHasil::where('periode_id', $periodeId)->first();
        $status = $validasi ? $validasi->status_validasi : 'menunggu';

        // 5. Proteksi URL: Blokir HRD jika belum disetujui Direktur
        if (auth()->user()->role == 'hrd' && $status != 'disetujui') {
            return redirect()->route('hasil.index', ['periode_id' => $periodeId])
                ->with('error', 'Akses ditolak. Hasil belum disetujui atau telah ditolak oleh Direktur Utama.');
        }

        // 6. Panggil service Profile Matching
        $service = new ProfileMatchingService($periodeId);
        $data = $service->getDetailPerhitungan($id);

        if (!$data) {
            return redirect()->route('hasil.index', ['periode_id' => $periodeId])
                ->with('error', 'Data perhitungan tidak ditemukan.');
        }

        // 7. Selipkan status validasi ke dalam array data agar dibaca oleh Blade
        $data['statusValidasi'] = $status;

        return view('hasil.show', $data);
    }

    /**
     * Mengekspor laporan hasil ke format PDF dengan proteksi URL.
     */
    public function exportPDF(Request $request)
    {
        $periodeId = $request->input('periode_id');

        if (!$periodeId) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan');
        }

        $periode = PeriodePenilaian::find($periodeId);

        if (!$periode) {
            return redirect()->route('hasil.index')
                ->with('error', 'Periode tidak ditemukan');
        }

        $validasi = ValidasiHasil::with('user')
            ->where('periode_id', $periode->id)
            ->first();

        $statusValidasi = $validasi ? $validasi->status_validasi : 'menunggu';

        // Proteksi URL PDF: Blokir HRD jika mencoba export laporan yang belum disetujui
        if (auth()->user()->role == 'hrd' && $statusValidasi != 'disetujui') {
            return redirect()->route('hasil.index', [
                'periode_id' => $periodeId
            ])->with('error', 'Laporan belum disetujui atau telah ditolak oleh Direktur Utama.');
        }

        $hasilList = HasilPerhitungan::with('karyawan')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking', 'ASC')
            ->get();

        if ($hasilList->isEmpty()) {
            return redirect()->route('hasil.index', [
                'periode_id' => $periodeId
            ])->with('error', 'Belum ada data hasil perhitungan.');
        }

        $stats = [
            'total' => $hasilList->count(),
            'klasifikasi_a' => $hasilList->where('klasifikasi', 'A')->count(),
            'klasifikasi_b' => $hasilList->where('klasifikasi', 'B')->count(),
            'klasifikasi_c' => $hasilList->where('klasifikasi', 'C')->count(),
            'klasifikasi_d' => $hasilList->where('klasifikasi', 'D')->count(),
        ];

        // Memanggil class PDF secara absolut untuk menghindari error Class Not Found
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('hasil.pdf', [
            'hasilList' => $hasilList,
            'periode' => $periode,
            'stats' => $stats,
            'validasi' => $validasi,
            'statusValidasi' => $statusValidasi,
        ]);

        $pdf->setPaper('a4', 'landscape');

        $namaFile = 'Laporan_Hasil_Penilaian_' .
            str_replace('/', '_', ($periode->nama ?? $periode->id)) .
            '.pdf';

        return $pdf->download($namaFile);
    }
}