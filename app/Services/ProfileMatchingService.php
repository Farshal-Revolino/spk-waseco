<?php

namespace App\Services;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\ProfilIdeal;
use App\Models\BobotGap;
use App\Models\HasilGap;
use App\Models\HasilPerhitungan;
use Illuminate\Support\Facades\DB;

class ProfileMatchingService
{
    protected $periodeId;
    protected $coreFactor = 60;
    protected $secondaryFactor = 40;

    public function __construct($periodeId = null)
    {
        $this->periodeId = $periodeId;
    }

    public function calculate()
    {
        try {
            DB::beginTransaction();

            HasilPerhitungan::where('periode_id', $this->periodeId)->delete();

            $karyawanList = Karyawan::whereHas('penilaian', function ($query) {
                $query->where('periode_id', $this->periodeId);
            })->get();

            if ($karyawanList->isEmpty()) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Tidak ada data penilaian untuk periode ini'
                ];
            }

            $results = [];

            foreach ($karyawanList as $karyawan) {
                $this->calculateGapAnalysis($karyawan->id);
                $hasilKriteria = $this->calculateFactors($karyawan->id);
                $nilaiTotal = $this->calculateNilaiTotal($hasilKriteria);
                $hasil = $this->saveHasilPerhitungan($karyawan->id, $hasilKriteria, $nilaiTotal);
                $results[] = $hasil;
            }

            $this->updateRanking();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Perhitungan Profile Matching berhasil dilakukan!',
                'data' => $results
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    protected function calculateGapAnalysis($karyawanId)
    {
        $penilaianList = Penilaian::where('karyawan_id', $karyawanId)
            ->where('periode_id', $this->periodeId)
            ->get();

        foreach ($penilaianList as $penilaian) {
            $profilIdeal = ProfilIdeal::where('sub_kriteria_id', $penilaian->sub_kriteria_id)->first();

            $nilaiIdeal = $profilIdeal ? $profilIdeal->nilai_ideal : 0;
            $gap = $penilaian->nilai - $nilaiIdeal;
            $bobot = BobotGap::getBobotBySelisih($gap);

            HasilGap::updateOrCreate(
                ['penilaian_id' => $penilaian->id],
                [
                    'gap' => $gap,
                    'bobot' => $bobot
                ]
            );
        }
    }

    protected function calculateFactors($karyawanId)
    {
        $kriteriaList = Kriteria::with('subKriteria')->orderBy('urutan')->get();
        $hasil = [];

        foreach ($kriteriaList as $kriteria) {
            $subKriteriaIds = $kriteria->subKriteria->pluck('id')->toArray();

            $penilaianList = Penilaian::whereIn('sub_kriteria_id', $subKriteriaIds)
                ->where('karyawan_id', $karyawanId)
                ->where('periode_id', $this->periodeId)
                ->get();

            $coreValues = [];
            $secondaryValues = [];

            foreach ($penilaianList as $penilaian) {
                $subKriteria = $kriteria->subKriteria
                    ->where('id', $penilaian->sub_kriteria_id)
                    ->first();

                $hasilGap = HasilGap::where('penilaian_id', $penilaian->id)->first();

                if ($hasilGap && $subKriteria) {
                    if ($subKriteria->tipe == 'core') {
                        $coreValues[] = $hasilGap->bobot;
                    } else {
                        $secondaryValues[] = $hasilGap->bobot;
                    }
                }
            }

            $jumlahCore = count($coreValues);
            $jumlahSecondary = count($secondaryValues);

            $ncf = $jumlahCore > 0
                ? array_sum($coreValues) / $jumlahCore
                : 0;

            $nsf = $jumlahSecondary > 0
                ? array_sum($secondaryValues) / $jumlahSecondary
                : 0;

            /*
             * Jika kriteria memiliki Core dan Secondary:
             * Nilai = 60% NCF + 40% NSF
             *
             * Jika kriteria hanya memiliki Core:
             * Nilai = NCF
             *
             * Jika kriteria hanya memiliki Secondary:
             * Nilai = NSF
             */
            if ($jumlahCore > 0 && $jumlahSecondary > 0) {
                $nilaiKriteria = ($this->coreFactor / 100 * $ncf) +
                                 ($this->secondaryFactor / 100 * $nsf);
            } elseif ($jumlahCore > 0 && $jumlahSecondary == 0) {
                $nilaiKriteria = $ncf;
            } elseif ($jumlahCore == 0 && $jumlahSecondary > 0) {
                $nilaiKriteria = $nsf;
            } else {
                $nilaiKriteria = 0;
            }

            $hasil[$kriteria->kode] = [
                'nama'  => $kriteria->nama,
                'ncf'   => round($ncf, 2),
                'nsf'   => round($nsf, 2),
                'nilai' => round($nilaiKriteria, 2),
                'bobot' => $kriteria->bobot
            ];
        }

        return $hasil;
    }

    protected function calculateNilaiTotal($hasilKriteria)
    {
        /*
         * Nilai setiap aspek berada pada skala maksimal 5.
         * Bobot kriteria:
         * K1 = 35%, K2 = 25%, K3 = 25%, K4 = 15%.
         *
         * Nilai akhir Profile Matching dikonversi
         * ke skala maksimal perusahaan yaitu 320.
         */

        $nilaiAkhirProfile = 0;

        foreach ($hasilKriteria as $data) {
            $nilaiAkhirProfile += ($data['nilai'] * ($data['bobot'] / 100));
        }

        $skorAkhir = ($nilaiAkhirProfile / 5) * 320;

        return round($skorAkhir, 2);
    }

    protected function saveHasilPerhitungan($karyawanId, $hasilKriteria, $nilaiTotal)
    {
        $klasifikasi = HasilPerhitungan::determineKlasifikasi($nilaiTotal);

        $data = [
            'karyawan_id'  => $karyawanId,
            'periode_id'   => $this->periodeId,
            'nilai_total'  => $nilaiTotal,
            'klasifikasi'  => $klasifikasi
        ];

        if (isset($hasilKriteria['K1'])) {
            $data['ncf_teknis']   = $hasilKriteria['K1']['ncf'];
            $data['nsf_teknis']   = $hasilKriteria['K1']['nsf'];
            $data['nilai_teknis'] = $hasilKriteria['K1']['nilai'];
        }

        if (isset($hasilKriteria['K2'])) {
            $data['ncf_non_teknis']   = $hasilKriteria['K2']['ncf'];
            $data['nsf_non_teknis']   = $hasilKriteria['K2']['nsf'];
            $data['nilai_non_teknis'] = $hasilKriteria['K2']['nilai'];
        }

        if (isset($hasilKriteria['K3'])) {
            $data['ncf_kepribadian']   = $hasilKriteria['K3']['ncf'];
            $data['nsf_kepribadian']   = $hasilKriteria['K3']['nsf'];
            $data['nilai_kepribadian'] = $hasilKriteria['K3']['nilai'];
        }

        if (isset($hasilKriteria['K4'])) {
            $data['ncf_kepemimpinan']   = $hasilKriteria['K4']['ncf'];
            $data['nsf_kepemimpinan']   = $hasilKriteria['K4']['nsf'];
            $data['nilai_kepemimpinan'] = $hasilKriteria['K4']['nilai'];
        }

        return HasilPerhitungan::updateOrCreate(
            [
                'karyawan_id' => $karyawanId,
                'periode_id'  => $this->periodeId
            ],
            $data
        );
    }

    protected function updateRanking()
    {
        $hasilList = HasilPerhitungan::where('periode_id', $this->periodeId)
            ->orderBy('nilai_total', 'DESC')
            ->get();

        $ranking = 1;

        foreach ($hasilList as $hasil) {
            $hasil->ranking = $ranking++;
            $hasil->save();
        }
    }

    public function getDetailPerhitungan($karyawanId)
    {
        $karyawan = Karyawan::find($karyawanId);

        if (!$karyawan) {
            return null;
        }

        $hasil = HasilPerhitungan::where('karyawan_id', $karyawanId)
            ->where('periode_id', $this->periodeId)
            ->first();

        if (!$hasil) {
            return null;
        }

        $kriteriaList = Kriteria::with(['subKriteria.profilIdeal'])
            ->orderBy('urutan')
            ->get();

        $detailKriteria = [];

        foreach ($kriteriaList as $kriteria) {
            $subKriteriaIds = $kriteria->subKriteria->pluck('id')->toArray();

            $penilaianList = Penilaian::with(['subKriteria', 'hasilGap'])
                ->whereIn('sub_kriteria_id', $subKriteriaIds)
                ->where('karyawan_id', $karyawanId)
                ->where('periode_id', $this->periodeId)
                ->get();

            $detailSub = [];

            foreach ($penilaianList as $penilaian) {
                $profilIdeal = $penilaian->subKriteria->profilIdeal;
                $hasilGap    = $penilaian->hasilGap;

                $detailSub[] = [
                    'nama'        => $penilaian->subKriteria->nama,
                    'tipe'        => $penilaian->subKriteria->tipe,
                    'nilai'       => $penilaian->nilai,
                    'nilai_ideal' => $profilIdeal ? $profilIdeal->nilai_ideal : 0,
                    'gap'         => $hasilGap ? $hasilGap->gap : 0,
                    'bobot'       => $hasilGap ? $hasilGap->bobot : 0
                ];
            }

            $detailKriteria[] = [
                'nama'         => $kriteria->nama,
                'kode'         => $kriteria->kode,
                'bobot'        => $kriteria->bobot,
                'sub_kriteria' => $detailSub
            ];
        }

        return [
            'karyawan'        => $karyawan,
            'hasil'           => $hasil,
            'detail_kriteria' => $detailKriteria
        ];
    }
}