@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan dan Statistik Penilaian Karyawan')

@section('content')
    <div class="dashboard-bg">
        <div class="dashboard-overlay"></div>

        <div class="dashboard-content">

            <!-- ================= STATISTICS ================= -->
            <div class="row">

                @php
                    $stats = [
                        ['title' => 'Total Karyawan', 'value' => $totalKaryawan, 'icon' => 'bi-people-fill'],
                        ['title' => 'Total Kriteria', 'value' => $totalKriteria, 'icon' => 'bi-list-check'],
                        ['title' => 'Total Periode', 'value' => $totalPeriode, 'icon' => 'bi-calendar3'],
                        ['title' => 'Data Penilaian', 'value' => $totalPenilaian, 'icon' => 'bi-clipboard-data'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 text-muted">{{ $stat['title'] }}</p>
                                    <h3 class="mb-0">{{ $stat['value'] }}</h3>
                                </div>
                                <div class="fs-1 text-secondary">
                                    <i class="bi {{ $stat['icon'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- ================= PERIODE ================= -->
            @if($periodeAktif)
                <div class="alert alert-info border-0 mt-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle me-3 fs-4"></i>
                        <div>
                            <strong>Periode Aktif:</strong>
                            {{ $periodeAktif->nama }} ({{ $periodeAktif->tahun }})
                            <br>
                            <small>
                                {{ $periodeAktif->tanggal_mulai->format('d M Y') }} -
                                {{ $periodeAktif->tanggal_selesai->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning border-0 mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Tidak ada periode penilaian aktif.
                </div>
            @endif

            <!-- ================= TOP KARYAWAN ================= -->
            <div class="row mt-3">

                <div class="col-lg-7 col-12">
                    <div class="card glass-card">

                        <!-- HEADER -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-trophy me-2 text-warning"></i>
                                <strong>Top 5 Karyawan</strong>
                                @if($periodeAktif)
                                    <br>
                                    <small class="text-muted">{{ $periodeAktif->nama }}</small>
                                @endif
                            </div>
                        </div>

                        <!-- BODY -->
                        <div class="card-body p-0">

                            @if(count($topKaryawan) > 0)

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle glass-table">

                                        <thead class="table-light">
                                            <tr>
                                                <th>Rank</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th class="text-end">Nilai</th>
                                                <th class="text-center">Klasifikasi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($topKaryawan as $hasil)
                                                <tr>

                                                    <!-- RANK -->
                                                    <td>
                                                        <span class="badge
                                                                                                @if($hasil->ranking == 1) bg-warning text-dark
                                                                                                @elseif($hasil->ranking == 2) bg-secondary
                                                                                                @elseif($hasil->ranking == 3) bg-danger
                                                                                                @else bg-light text-dark
                                                                                                @endif">
                                                            #{{ $hasil->ranking }}
                                                        </span>
                                                    </td>

                                                    <!-- NIK -->
                                                    <td class="text-muted">
                                                        {{ $hasil->karyawan->nik }}
                                                    </td>

                                                    <!-- NAMA -->
                                                    <td>
                                                        <strong>{{ $hasil->karyawan->nama }}</strong>
                                                    </td>

                                                    <!-- JABATAN -->
                                                    <td>
                                                        {{ $hasil->karyawan->jabatan ?? '-' }}
                                                    </td>

                                                    <!-- NILAI -->
                                                    <td class="text-end fw-bold text-primary">
                                                        {{ number_format($hasil->nilai_total, 2) }}
                                                    </td>

                                                    <!-- KLASIFIKASI -->
                                                    <td class="text-center">
                                                        <span class="badge bg-{{ $hasil->klasifikasi_badge }}">
                                                            {{ $hasil->klasifikasi }}
                                                        </span>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                            @else
                                <!-- EMPTY STATE -->
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada hasil perhitungan</p>

                                    @if($periodeAktif)
                                        <a href="{{ route('hasil.index') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-calculator me-2"></i>Mulai Perhitungan
                                        </a>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
            <!-- ================= QUICK ACTION ================= -->
            <div class="row mt-3">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-lightning me-2"></i>Quick Actions
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <a href="{{ route('karyawan.create') }}" class="btn btn-outline-primary w-100 mb-2">
                                        <i class="bi bi-person-plus me-2"></i>Tambah Karyawan
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a href="{{ route('penilaian.index') }}" class="btn btn-outline-success w-100 mb-2">
                                        <i class="bi bi-clipboard-plus me-2"></i>Input Penilaian
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a href="{{ route('hasil.index') }}" class="btn btn-outline-warning w-100 mb-2">
                                        <i class="bi bi-calculator me-2"></i>Lihat Hasil
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    @if($periodeAktif && count($topKaryawan) > 0)
                                        <a href="{{ route('hasil.export-pdf') }}?periode_id={{ $periodeAktif->id }}"
                                            class="btn btn-outline-danger w-100 mb-2" target="_blank">
                                            <i class="bi bi-file-earmark-pdf me-2"></i>Cetak Laporan
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary w-100 mb-2" disabled>
                                            <i class="bi bi-file-earmark-pdf me-2"></i>Cetak Laporan
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection