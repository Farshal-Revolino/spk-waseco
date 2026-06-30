@extends('layouts.app')

@section('title', 'Dashboard Direktur')
@section('page-title', 'Dashboard Direktur Utama')
@section('page-subtitle', 'Validasi hasil penilaian karyawan terbaik')

@section('styles')
    <style>
        .director-hero {
            background: linear-gradient(135deg, #0b2447, #19376d, #0d6efd);
            border-radius: 24px;
            padding: 28px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(13, 110, 253, .22);
            margin-bottom: 24px;
        }

        .director-hero::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .11);
            right: -85px;
            top: -95px;
        }

        .director-hero h3 {
            font-weight: 850;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }

        .director-hero p {
            margin-bottom: 0;
            opacity: .9;
            position: relative;
            z-index: 2;
        }

        .hero-icon {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }

        .director-card,
        .stat-card,
        .validation-box {
            border: none;
            border-radius: 22px;
            box-shadow: 0 10px 26px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .stat-card {
            height: 100%;
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 25px;
            flex-shrink: 0;
        }

        .bg-blue-soft {
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
        }

        .bg-green-soft {
            background: linear-gradient(135deg, #198754, #51cf66);
        }

        .bg-orange-soft {
            background: linear-gradient(135deg, #fd7e14, #ffc078);
        }

        .bg-purple-soft {
            background: linear-gradient(135deg, #6f42c1, #b197fc);
        }

        .status-badge-large {
            border-radius: 999px;
            padding: 10px 16px;
            font-weight: 800;
            font-size: 13px;
        }

        .top-card {
            border: none;
            border-radius: 22px;
            height: 100%;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .06);
            transition: .2s ease;
        }

        .top-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .09);
        }

        .rank-icon {
            width: 66px;
            height: 66px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 850;
            margin: 0 auto 14px;
        }

        .score-big {
            font-size: 32px;
            font-weight: 900;
            color: #0d6efd;
            line-height: 1;
        }

        .validation-header {
            padding: 20px 24px;
            border-bottom: 1px solid #edf0f3;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
        }

        .validation-form textarea {
            border-radius: 16px;
            resize: none;
        }

        .btn-action {
            border-radius: 14px;
            padding: 10px 18px;
            font-weight: 750;
        }

        .empty-director {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-director i {
            font-size: 60px;
            color: #adb5bd;
            display: block;
            margin-bottom: 14px;
        }

        @media (max-width: 768px) {
            .director-hero {
                padding: 22px;
            }

            .director-hero h3 {
                font-size: 21px;
            }

            .hero-icon {
                width: 58px;
                height: 58px;
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('content')

    @php
        $hasilCollection = collect($hasilList ?? [])->sortBy('ranking')->values();
        $topThree = $hasilCollection->take(3);

        $totalDinilai = $hasilCollection->count();
        $nilaiTertinggi = $hasilCollection->max('nilai_total') ?? 0;

        $jumlahA = $hasilCollection->where('klasifikasi', 'A')->count();
        $jumlahB = $hasilCollection->where('klasifikasi', 'B')->count();
        $jumlahC = $hasilCollection->where('klasifikasi', 'C')->count();
        $jumlahD = $hasilCollection->where('klasifikasi', 'D')->count();

        $status = $statusValidasi ?? 'menunggu';

        $badgeValidasi = [
            'menunggu' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
        ][$status] ?? 'secondary';

        $labelValidasi = [
            'menunggu' => 'Menunggu Validasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ][$status] ?? 'Tidak Diketahui';
    @endphp

    <div class="director-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <h3>Dashboard Validasi Direktur</h3>
                        <p>
                            Melihat Top 3 karyawan terbaik dan memvalidasi laporan hasil penilaian periode aktif.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0 position-relative" style="z-index:2;">
                <span class="badge bg-light text-dark status-badge-large">
                    <i class="bi bi-calendar-check me-1"></i>
                    {{ $periode ? $periode->nama . ' (' . $periode->tahun . ')' : 'Belum Ada Periode' }}
                </span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Dinilai</div>
                        <h3 class="fw-bold mb-0">{{ $totalDinilai }}</h3>
                    </div>

                    <div class="stat-icon bg-blue-soft">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Nilai Tertinggi</div>
                        <h3 class="fw-bold mb-0">{{ number_format($nilaiTertinggi, 2) }}</h3>
                    </div>

                    <div class="stat-icon bg-orange-soft">
                        <i class="bi bi-award-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Klasifikasi A</div>
                        <h3 class="fw-bold mb-0">{{ $jumlahA }}</h3>
                    </div>

                    <div class="stat-icon bg-green-soft">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Status Validasi</div>
                        <span class="badge bg-{{ $badgeValidasi }} fs-6 mt-1">
                            {{ $labelValidasi }}
                        </span>
                    </div>

                    <div class="stat-icon bg-purple-soft">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($periode && $totalDinilai > 0)

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card director-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-trophy-fill text-warning me-2"></i>
                                Top 3 Karyawan Terbaik
                            </h5>
                            <small class="text-muted">
                                {{ $periode->nama }} ({{ $periode->tahun }})
                            </small>
                        </div>

                        <a href="{{ route('hasil.index') }}?periode_id={{ $periode->id }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-list-ol me-1"></i>
                            Ranking Lengkap
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($topThree as $hasil)
                                @php
                                    $rank = $hasil->ranking ?? $loop->iteration;
                                    $rankClass = match ($rank) {
                                        1 => 'bg-warning text-dark',
                                        2 => 'bg-secondary text-white',
                                        3 => 'bg-danger text-white',
                                        default => 'bg-light text-dark'
                                    };

                                    $badgeKelas = match ($hasil->klasifikasi) {
                                        'A' => 'success',
                                        'B' => 'primary',
                                        'C' => 'warning',
                                        'D' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp

                                <div class="col-md-4">
                                    <div class="card top-card">
                                        <div class="card-body text-center">
                                            <div class="rank-icon {{ $rankClass }}">
                                                <i class="bi bi-trophy-fill"></i>
                                            </div>

                                            <span class="badge {{ $rankClass }} mb-3">
                                                Ranking #{{ $rank }}
                                            </span>

                                            <h6 class="fw-bold mb-1">
                                                {{ $hasil->karyawan->nama }}
                                            </h6>

                                            <div class="text-muted small mb-3">
                                                {{ $hasil->karyawan->jabatan ?? '-' }}
                                            </div>

                                            <div class="score-big mb-1">
                                                {{ number_format($hasil->nilai_total, 2) }}
                                            </div>

                                            <span class="badge bg-{{ $badgeKelas }} mb-3">
                                                Kelas {{ $hasil->klasifikasi }}
                                            </span>

                                            <div>
                                                <a href="{{ route('hasil.show', $hasil->karyawan_id) }}?periode_id={{ $hasil->periode_id }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye me-1"></i>
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="alert alert-light border mt-4 mb-0">
                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                            Dashboard Direktur hanya menampilkan Top 3 karyawan terbaik.
                            Data ranking lengkap dapat dilihat melalui tombol
                            <strong>Ranking Lengkap</strong>.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card director-card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-shield-check text-primary me-2"></i>
                            Status Validasi Laporan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted small">Status Saat Ini:</span>
                            <span class="badge bg-{{ $badgeValidasi }} px-3 py-2">
                                {{ $labelValidasi }}
                            </span>
                        </div>

                        @if($validasi)
                            <div class="p-3 bg-light rounded mb-3 small">
                                <strong>Keterangan:</strong><br>
                                Oleh: {{ $validasi->user->name ?? '-' }}<br>
                                Tanggal: {{ $validasi->tanggal_validasi ? \Carbon\Carbon::parse($validasi->tanggal_validasi)->format('d M Y H:i') : '-' }}
                                @if($validasi->catatan_validasi)
                                    <hr class="my-2">
                                    <strong>Catatan:</strong> "{{ $validasi->catatan_validasi }}"
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning p-2 small mb-3">
                                <i class="bi bi-info-circle me-1"></i> Belum divalidasi oleh Direktur.
                            </div>
                        @endif

                        <div class="d-grid">
                            <a href="{{ route('direktur.validasi') }}" class="btn btn-primary py-2 fw-bold">
                                <i class="bi bi-shield-check me-1"></i>
                                Kelola Validasi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card director-card">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                            Ringkasan Klasifikasi
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Baik Sekali (A)</span>
                            <strong>{{ $jumlahA }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Baik (B)</span>
                            <strong>{{ $jumlahB }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Cukup (C)</span>
                            <strong>{{ $jumlahC }}</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Kurang (D)</span>
                            <strong>{{ $jumlahD }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="card director-card">
            <div class="empty-director">
                <i class="bi bi-clipboard-x"></i>
                <h4 class="fw-bold">Belum Ada Hasil Penilaian</h4>
                <p class="mb-0">
                    Hasil perhitungan belum tersedia. HRD/Admin perlu melakukan input penilaian dan proses perhitungan terlebih
                    dahulu.
                </p>
            </div>
        </div>
    @endif

@endsection