@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page-title', 'Input Penilaian Karyawan')
@section('page-subtitle', 'Input nilai penilaian karyawan berdasarkan kriteria')

@section('styles')
    <style>
        .page-hero {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #fff;
            border-radius: 22px;
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.22);
            position: relative;
            overflow: hidden;
        }

        .page-hero::after {
            content: "";
            position: absolute;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -70px;
            top: -80px;
        }

        .hero-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            flex-shrink: 0;
        }

        .page-hero h4 {
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-hero p {
            margin-bottom: 0;
            opacity: .9;
        }

        .period-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
            overflow: hidden;
            margin-bottom: 22px;
        }

        .period-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
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
            padding: 14px 12px;
        }

        .table-modern td {
            vertical-align: middle;
            padding: 14px 12px;
        }

        .employee-avatar {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .employee-name {
            font-weight: 800;
            color: #212529;
            margin-bottom: 2px;
        }

        .employee-sub {
            font-size: 12px;
            color: #6c757d;
        }

        .unit-badge {
            background: #f1f3f5;
            color: #495057;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .progress {
            height: 12px;
            border-radius: 20px;
            background: #edf0f3;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 20px;
        }

        .progress-label {
            font-size: 12px;
            font-weight: 800;
            color: #495057;
            min-width: 42px;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 12px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-complete {
            background: #e9f7ef;
            color: #198754;
        }

        .status-progress {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .status-empty {
            background: #fff4db;
            color: #b7791f;
        }

        .action-btn {
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 12px;
        }

        .empty-state {
            text-align: center;
            padding: 55px 20px;
        }

        .empty-state i {
            font-size: 52px;
            color: #adb5bd;
        }

        .warning-card {
            border: none;
            border-radius: 20px;
            background: #fff4db;
            color: #8a5a00;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
            padding: 22px;
        }

        .summary-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
            height: 100%;
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
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
    </style>
@endsection

@section('content')

    @if(!$periodeAktif)
        <div class="warning-card">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div>
                    <h5 class="mb-1">Tidak ada periode penilaian aktif</h5>
                    <p class="mb-0">Silakan aktifkan periode penilaian terlebih dahulu sebelum melakukan input nilai karyawan.
                    </p>
                </div>
            </div>
        </div>
    @else

        @php
            $totalKaryawan = $karyawanList->count();
            $totalSelesai = $karyawanList->where('is_complete', true)->count();
            $totalBelum = $totalKaryawan - $totalSelesai;
        @endphp

        @if($periodeAktif->status_validasi === 'divalidasi')
            <div class="alert alert-info shadow-sm mb-4 d-flex align-items-center gap-3">
                <div class="fs-3 text-info"><i class="bi bi-lock-fill"></i></div>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Penilaian Terkunci (Laporan Sudah Disetujui Direktur Utama)</h6>
                    <p class="mb-0 text-muted small">
                        Laporan hasil penilaian untuk periode <strong>{{ $periodeAktif->nama }}</strong> telah divalidasi dan disetujui oleh Direktur Utama. Penilaian karyawan dikunci dan tidak dapat diubah kembali demi integritas data.
                    </p>
                </div>
            </div>
        @endif

        <div class="page-hero">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="hero-icon">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <div>
                            <h4>Input Penilaian Karyawan</h4>
                            <p>Pilih karyawan yang akan dinilai berdasarkan kriteria metode Profile Matching.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="btn btn-light fw-bold">
                        <i class="bi bi-calendar-check me-2"></i>{{ $periodeAktif->nama }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card period-card">
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <div class="col-lg-7">
                        <div class="d-flex align-items-center gap-3">
                            <div class="period-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>

                            <div>
                                <div class="text-muted small">Periode Aktif</div>
                                <h5 class="mb-1 fw-bold text-primary">
                                    {{ $periodeAktif->nama }} ({{ $periodeAktif->tahun }})
                                </h5>
                                <small class="text-muted">
                                    {{ $periodeAktif->tanggal_mulai->format('d M Y') }}
                                    -
                                    {{ $periodeAktif->tanggal_selesai->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <span class="status-chip status-complete me-1 mb-1">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ $totalSelesai }} Selesai
                        </span>

                        <span class="status-chip status-empty mb-1">
                            <i class="bi bi-hourglass-split"></i>
                            {{ $totalBelum }} Belum Selesai
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card summary-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Karyawan</div>
                            <h3 class="fw-bold mb-0">{{ $totalKaryawan }}</h3>
                        </div>
                        <div class="summary-icon bg-blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card summary-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Sudah Dinilai</div>
                            <h3 class="fw-bold mb-0">{{ $totalSelesai }}</h3>
                        </div>
                        <div class="summary-icon bg-green">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card summary-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Belum Selesai</div>
                            <h3 class="fw-bold mb-0">{{ $totalBelum }}</h3>
                        </div>
                        <div class="summary-icon bg-orange">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card main-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="bi bi-table me-2 text-primary"></i>
                        Daftar Karyawan untuk Dinilai
                    </h5>
                    <small class="text-muted">Klik tombol mulai untuk mengisi nilai karyawan</small>
                </div>
            </div>

            <div class="card-body p-0">
                @if($karyawanList->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-modern datatable mb-0">
                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>Karyawan</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th width="230">Progress Penilaian</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($karyawanList as $index => $k)
                                    <tr>
                                        <td class="fw-bold text-muted">{{ $index + 1 }}</td>

                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="employee-avatar">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>

                                                <div>
                                                    <div class="employee-name">{{ $k->nama }}</div>
                                                    <div class="employee-sub">NIK: {{ $k->nik }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $k->jabatan ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="unit-badge">
                                                {{ $k->unit_kerja ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="progress flex-grow-1">
                                                    <div class="progress-bar
                                                                    @if($k->is_complete) bg-success
                                                                    @elseif($k->progress > 50) bg-primary
                                                                    @else bg-warning
                                                                    @endif" role="progressbar" style="width: {{ $k->progress }}%"
                                                        aria-valuenow="{{ $k->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>

                                                <span class="progress-label">
                                                    {{ $k->progress }}%
                                                </span>
                                            </div>

                                            @if($k->is_complete)
                                                <span class="status-chip status-complete">
                                                    <i class="bi bi-check-circle-fill"></i>Selesai
                                                </span>
                                            @elseif($k->progress > 0)
                                                <span class="status-chip status-progress">
                                                    <i class="bi bi-arrow-repeat"></i>Dalam Proses
                                                </span>
                                            @else
                                                <span class="status-chip status-empty">
                                                    <i class="bi bi-hourglass"></i>Belum Dinilai
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if($periodeAktif->status_validasi === 'divalidasi')
                                                <a href="{{ route('penilaian.create') }}?karyawan_id={{ $k->id }}"
                                                    class="btn btn-info btn-sm action-btn text-white">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                            @else
                                                @if($k->is_complete)
                                                    <a href="{{ route('penilaian.create') }}?karyawan_id={{ $k->id }}"
                                                        class="btn btn-warning btn-sm action-btn">
                                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                                    </a>
                                                @else
                                                    <a href="{{ route('penilaian.create') }}?karyawan_id={{ $k->id }}"
                                                        class="btn btn-primary btn-sm action-btn">
                                                        @if($k->progress > 0)
                                                            <i class="bi bi-arrow-repeat me-1"></i>Lanjutkan
                                                        @else
                                                            <i class="bi bi-plus-circle me-1"></i>Mulai
                                                        @endif
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5 class="mt-3">Belum ada karyawan</h5>
                        <p class="text-muted">Silakan tambahkan data karyawan terlebih dahulu sebelum melakukan penilaian.</p>
                        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Tambah Karyawan
                        </a>
                    </div>
                @endif
            </div>
        </div>

    @endif

@endsection