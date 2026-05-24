@extends('layouts.app')

@section('title', 'Detail Perhitungan')
@section('page-title', 'Detail Perhitungan')
@section('page-subtitle', 'Breakdown Profile Matching - ' . $karyawan->nama)

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

        .main-card,
        .info-card,
        .score-card,
        .aspect-card {
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

        .employee-avatar {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 8px 24px rgba(13, 110, 253, .20);
        }

        .employee-name {
            font-weight: 800;
            color: #212529;
            margin-bottom: 4px;
        }

        .employee-detail {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 0;
        }

        .rank-box {
            background: #f8f9fb;
            border: 1px solid #edf0f3;
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            min-width: 150px;
        }

        .rank-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: .6px;
            font-weight: 700;
        }

        .rank-number {
            font-size: 34px;
            font-weight: 900;
            color: #0d6efd;
            line-height: 1;
            margin: 6px 0;
        }

        .score-card {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #fff;
            height: 100%;
        }

        .score-label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .8px;
            opacity: .85;
            font-weight: 700;
        }

        .score-value {
            font-size: 48px;
            font-weight: 900;
            line-height: 1;
            margin: 12px 0 6px;
        }

        .score-max {
            font-size: 13px;
            opacity: .85;
        }

        .score-progress {
            height: 10px;
            background: rgba(255, 255, 255, .25);
            border-radius: 20px;
            overflow: hidden;
            margin-top: 18px;
        }

        .score-progress-bar {
            height: 100%;
            background: #fff;
            border-radius: 20px;
        }

        .aspect-card {
            height: 100%;
            transition: .2s;
        }

        .aspect-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .10);
        }

        .aspect-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 23px;
            margin-bottom: 12px;
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

        .aspect-title {
            font-size: 13px;
            color: #6c757d;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .aspect-value {
            font-size: 30px;
            font-weight: 900;
            color: #212529;
            margin-bottom: 6px;
        }

        .aspect-meta {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 0;
        }

        .table-modern th {
            background: #f8f9fb;
            color: #495057;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: none;
            padding: 14px 12px;
            white-space: nowrap;
        }

        .table-modern td {
            vertical-align: middle;
            padding: 14px 12px;
        }

        .criteria-badge {
            background: #e7f1ff;
            color: #0d6efd;
            border-radius: 12px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .factor-badge {
            border-radius: 10px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-core {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .badge-secondary {
            background: #fff4db;
            color: #b7791f;
        }

        .gap-badge {
            min-width: 44px;
            display: inline-block;
            border-radius: 10px;
            padding: 7px 10px;
            font-weight: 800;
        }

        .bobot-pill {
            background: #f1f3f5;
            color: #212529;
            border-radius: 10px;
            padding: 7px 12px;
            font-weight: 800;
            display: inline-block;
        }

        .btn {
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')

    <div class="page-hero">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon">
                        <i class="bi bi-bar-chart-line-fill"></i>
                    </div>
                    <div>
                        <h4>Detail Perhitungan</h4>
                        <p>Rincian hasil perhitungan metode Profile Matching untuk karyawan terpilih.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('hasil.index') }}?periode_id={{ $hasil->periode_id }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- INFO KARYAWAN --}}
    <div class="card info-card mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="employee-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div>
                            <h4 class="employee-name">{{ $karyawan->nama }}</h4>
                            <p class="employee-detail">
                                <i class="bi bi-credit-card me-1"></i>{{ $karyawan->nik }}
                                &nbsp;|&nbsp;
                                <i class="bi bi-briefcase me-1"></i>{{ $karyawan->jabatan ?? '-' }}
                                &nbsp;|&nbsp;
                                <i class="bi bi-building me-1"></i>{{ $karyawan->unit_kerja ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="rank-box d-inline-block">
                        <div class="rank-label">Ranking</div>
                        <div class="rank-number">#{{ $hasil->ranking }}</div>
                        <span class="badge bg-{{ $hasil->klasifikasi_badge }}">
                            Kelas {{ $hasil->klasifikasi }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NILAI TOTAL & PER ASPEK --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-3">
            <div class="score-card">
                <div class="card-body d-flex flex-column justify-content-center text-center p-4">
                    <div class="score-label">Nilai Total</div>

                    <div class="score-value">
                        {{ number_format($hasil->nilai_total, 2) }}
                    </div>

                    <div class="score-max">dari maksimal 320</div>

                    @php
                        $persentaseNilai = ($hasil->nilai_total / 320) * 100;
                        $persentaseNilai = $persentaseNilai > 100 ? 100 : $persentaseNilai;
                    @endphp

                    <div class="score-progress">
                        <div class="score-progress-bar" style="width: {{ $persentaseNilai }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-3">
                <div class="col-md-6 col-xl-3">
                    <div class="card aspect-card">
                        <div class="card-body">
                            <div class="aspect-icon bg-blue">
                                <i class="bi bi-tools"></i>
                            </div>
                            <div class="aspect-title">Teknis</div>
                            <div class="aspect-value">{{ number_format($hasil->nilai_teknis, 2) }}</div>
                            <p class="aspect-meta">Bobot 35%</p>
                            <p class="aspect-meta">NCF: {{ $hasil->ncf_teknis }} | NSF: {{ $hasil->nsf_teknis }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card aspect-card">
                        <div class="card-body">
                            <div class="aspect-icon bg-green">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="aspect-title">Non Teknis</div>
                            <div class="aspect-value">{{ number_format($hasil->nilai_non_teknis, 2) }}</div>
                            <p class="aspect-meta">Bobot 25%</p>
                            <p class="aspect-meta">NCF: {{ $hasil->ncf_non_teknis }} | NSF: {{ $hasil->nsf_non_teknis }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card aspect-card">
                        <div class="card-body">
                            <div class="aspect-icon bg-orange">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div class="aspect-title">Kepribadian</div>
                            <div class="aspect-value">{{ number_format($hasil->nilai_kepribadian, 2) }}</div>
                            <p class="aspect-meta">Bobot 25%</p>
                            <p class="aspect-meta">NCF: {{ $hasil->ncf_kepribadian }} | NSF: {{ $hasil->nsf_kepribadian }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card aspect-card">
                        <div class="card-body">
                            <div class="aspect-icon bg-purple">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <div class="aspect-title">Kepemimpinan</div>
                            <div class="aspect-value">{{ number_format($hasil->nilai_kepemimpinan, 2) }}</div>
                            <p class="aspect-meta">Bobot 15%</p>
                            <p class="aspect-meta">NCF: {{ $hasil->ncf_kepemimpinan }} | NSF: {{ $hasil->nsf_kepemimpinan }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL PER KRITERIA --}}
    @foreach($detail_kriteria as $kriteria)
        <div class="card main-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="bi bi-bookmark-fill me-2 text-primary"></i>
                        {{ $kriteria['nama'] }}
                    </h5>
                    <small class="text-muted">Detail nilai aktual, target ideal, GAP, dan bobot GAP</small>
                </div>

                <span class="criteria-badge">
                    Bobot {{ $kriteria['bobot'] }}%
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Sub Kriteria</th>
                                <th width="130" class="text-center">Tipe</th>
                                <th width="130" class="text-center">Nilai Aktual</th>
                                <th width="130" class="text-center">Nilai Ideal</th>
                                <th width="100" class="text-center">GAP</th>
                                <th width="100" class="text-center">Bobot</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($kriteria['sub_kriteria'] as $sub)
                                <tr>
                                    <td>
                                        <strong>{{ $sub['nama'] }}</strong>
                                    </td>

                                    <td class="text-center">
                                        @if($sub['tipe'] == 'core')
                                            <span class="factor-badge badge-core">Core</span>
                                        @else
                                            <span class="factor-badge badge-secondary">Secondary</span>
                                        @endif
                                    </td>

                                    <td class="text-center fw-bold">
                                        {{ $sub['nilai'] }}
                                    </td>

                                    <td class="text-center text-muted fw-bold">
                                        {{ $sub['nilai_ideal'] }}
                                    </td>

                                    <td class="text-center">
                                        @if($sub['gap'] == 0)
                                            <span class="gap-badge bg-success text-white">
                                                0
                                            </span>
                                        @elseif($sub['gap'] > 0)
                                            <span class="gap-badge bg-info text-dark">
                                                +{{ $sub['gap'] }}
                                            </span>
                                        @else
                                            <span class="gap-badge bg-danger text-white">
                                                {{ $sub['gap'] }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="bobot-pill">
                                            {{ $sub['bobot'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <div class="text-center pb-4">
        <a href="{{ route('hasil.index') }}?periode_id={{ $hasil->periode_id }}" class="btn btn-secondary px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Hasil
        </a>
    </div>

@endsection