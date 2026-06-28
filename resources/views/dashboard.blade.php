
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan dan Statistik Penilaian Karyawan')

@section('styles')
    <style>
        .dashboard-modern {
            padding: 10px 0 30px;
        }

        .hero-dashboard {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            border-radius: 20px;
            padding: 28px;
            color: #fff;
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.25);
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .hero-dashboard::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -70px;
            top: -70px;
        }

        .hero-dashboard h3 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .hero-dashboard p {
            margin-bottom: 0;
            opacity: 0.9;
        }

        .periode-badge {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            padding: 12px 16px;
            border-radius: 14px;
            display: inline-block;
            font-size: 14px;
        }

        .stat-card-modern {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            transition: 0.25s;
            overflow: hidden;
        }

        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.10);
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #fff;
        }

        .stat-title {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #212529;
        }

        .bg-blue {
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
        }

        .bg-green {
            background: linear-gradient(135deg, #198754, #51cf66);
        }

        .bg-orange {
            background: linear-gradient(135deg, #fd7e14, #ffc078);
        }

        .bg-purple {
            background: linear-gradient(135deg, #6f42c1, #b197fc);
        }

        .main-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .main-card .card-header {
            background: #fff;
            border-bottom: 1px solid #edf0f3;
            padding: 18px 22px;
        }

        .table-modern th {
            background: #f8f9fb;
            color: #495057;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: none;
        }

        .table-modern td {
            vertical-align: middle;
            padding: 14px 12px;
        }

        .rank-badge {
            min-width: 42px;
            padding: 8px 10px;
            border-radius: 12px;
            font-weight: 700;
        }

        .quick-card {
            text-decoration: none;
            display: block;
            border-radius: 18px;
            padding: 22px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            transition: .25s;
            border: 1px solid #f1f3f5;
            height: 100%;
        }

        .quick-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.10);
        }

        .quick-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            margin-bottom: 14px;
        }

        .quick-title {
            font-weight: 700;
            color: #212529;
            margin-bottom: 4px;
        }

        .quick-desc {
            color: #6c757d;
            font-size: 13px;
            margin: 0;
        }

        .empty-state {
            padding: 55px 20px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-modern">

        {{-- HERO --}}
        <div class="hero-dashboard">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3>Dashboard Penilaian Karyawan</h3>
                    <p>Sistem Pendukung Keputusan penentuan karyawan terbaik menggunakan metode Profile Matching.</p>
                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @if($periodeAktif)
                        <div class="periode-badge">
                            <i class="bi bi-calendar-check me-2"></i>
                            <strong>{{ $periodeAktif->nama }}</strong><br>
                            <small>
                                {{ $periodeAktif->tanggal_mulai->format('d M Y') }}
                                -
                                {{ $periodeAktif->tanggal_selesai->format('d M Y') }}
                            </small>
                        </div>
                    @else
                        <div class="periode-badge">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Tidak ada periode aktif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- STATISTICS --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    [
                        'title' => 'Total Karyawan',
                        'value' => $totalKaryawan,
                        'icon' => 'bi-people-fill',
                        'color' => 'bg-blue'
                    ],
                    [
                        'title' => 'Total Kriteria',
                        'value' => $totalKriteria,
                        'icon' => 'bi-list-check',
                        'color' => 'bg-green'
                    ],
                    [
                        'title' => 'Total Periode',
                        'value' => $totalPeriode,
                        'icon' => 'bi-calendar3',
                        'color' => 'bg-orange'
                    ],
                    [
                        'title' => 'Data Penilaian',
                        'value' => $totalPenilaian,
                        'icon' => 'bi-clipboard-data',
                        'color' => 'bg-purple'
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card-modern">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-title">{{ $stat['title'] }}</div>
                                <div class="stat-value">{{ $stat['value'] }}</div>
                            </div>
                            <div class="stat-icon {{ $stat['color'] }}">
                                <i class="bi {{ $stat['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- MAIN CONTENT --}}
        <div class="row g-3">

            {{-- TOP 5 KARYAWAN --}}
            <div class="col-lg-8">
                <div class="card main-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="bi bi-trophy-fill text-warning me-2"></i>
                                Top 5 Karyawan
                            </h5>
                            @if($periodeAktif)
                                <small class="text-muted">{{ $periodeAktif->nama }} - {{ $periodeAktif->tahun }}</small>
                            @endif
                        </div>

                        <a href="{{ route('hasil.index') }}" class="btn btn-sm btn-primary">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="card-body p-0">
                        @if(count($topKaryawan) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-modern mb-0">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jabatan</th>
                                            <th class="text-end">Nilai</th>
                                            <th class="text-center">Kelas</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tbody>
                                        @foreach($topKaryawan as $hasil)
                                            <tr>
                                                <td>
                                                    @if($periodeAktif->status_validasi == 'divalidasi')
                                                        <span
                                                            class="badge rank-badge
                                                                                                                                                                                        @if($hasil->ranking == 1) bg-warning text-dark
                                                                                                                                                                                        @elseif($hasil->ranking == 2) bg-secondary
                                                                                                                                                                                        @elseif($hasil->ranking == 3) bg-danger
                                                                                                                                                                                        @else bg-light text-dark
                                                                                                                                                                                        @endif">
                                                            #{{ $hasil->ranking }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-light text-muted"><i class="bi bi-lock-fill"></i></span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="fw-bold">{{ $hasil->karyawan->nama }}</div>
                                                    <small class="text-muted">NIK: {{ $hasil->karyawan->nik }}</small>
                                                </td>

                                                <td>
                                                    {{ $hasil->karyawan->jabatan ?? '-' }}
                                                </td>

                                                <td class="text-end fw-bold text-primary">
                                                    @if($periodeAktif->status_validasi == 'divalidasi')
                                                        {{ number_format($hasil->nilai_total, 2) }}
                                                    @else
                                                        <span class="badge bg-warning text-dark" style="font-size: 0.75rem;">Menunggu
                                                            Validasi</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($periodeAktif->status_validasi == 'divalidasi')
                                                        <span class="badge bg-{{ $hasil->klasifikasi_badge }}">
                                                            {{ $hasil->klasifikasi }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <h6 class="mt-3">Belum ada hasil perhitungan</h6>
                                <p class="text-muted mb-3">Silakan lakukan proses perhitungan terlebih dahulu.</p>

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

            {{-- QUICK ACTION --}}
            <div class="col-lg-4">
                <div class="card main-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                            Quick Actions
                        </h5>
                        <small class="text-muted">Akses cepat fitur utama sistem</small>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-12">
                                <a href="{{ route('karyawan.create') }}" class="quick-card">
                                    <div class="quick-icon bg-blue">
                                        <i class="bi bi-person-plus"></i>
                                    </div>
                                    <div class="quick-title">Tambah Karyawan</div>
                                    <p class="quick-desc">Tambahkan data karyawan baru ke dalam sistem.</p>
                                </a>
                            </div>

                            <div class="col-12">
                                <a href="{{ route('penilaian.index') }}" class="quick-card">
                                    <div class="quick-icon bg-green">
                                        <i class="bi bi-clipboard-plus"></i>
                                    </div>
                                    <div class="quick-title">Input Penilaian</div>
                                    <p class="quick-desc">Masukkan nilai penilaian karyawan berdasarkan kriteria.</p>
                                </a>
                            </div>

                            <div class="col-12">
                                <a href="{{ route('hasil.index') }}" class="quick-card">
                                    <div class="quick-icon bg-orange">
                                        <i class="bi bi-bar-chart-line"></i>
                                    </div>
                                    <div class="quick-title">Lihat Hasil</div>
                                    <p class="quick-desc">Lihat hasil ranking dan detail perhitungan Profile Matching.</p>
                                </a>
                            </div>

             {{-- Ganti bagian tombol cetak laporan dengan kode ini saja --}}
<div class="col-12">
    @if($periodeAktif && count($topKaryawan) > 0)
        @if($periodeAktif->status_validasi == 'divalidasi')
            <a href="{{ route('hasil.export-pdf') }}?periode_id={{ $periodeAktif->id }}" 
               class="quick-card" target="_blank">
                <div class="quick-icon bg-purple">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div class="quick-title">Cetak Laporan</div>
                <p class="quick-desc">Cetak laporan hasil penilaian dalam format PDF.</p>
            </a>
        @else
            <div class="quick-card opacity-50">
                <div class="quick-icon bg-warning">
                    <i class="bi bi-lock-fill"></i>
                </div>
                <div class="quick-title">Cetak Laporan</div>
                <p class="quick-desc text-warning">Menunggu validasi Direktur.</p>
            </div>
        @endif
    @else
        <div class="quick-card opacity-50">
            <div class="quick-icon bg-purple">
                <i class="bi bi-file-earmark-pdf"></i>
            </div>
            <div class="quick-title">Cetak Laporan</div>
            <p class="quick-desc">Belum tersedia.</p>
        </div>
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