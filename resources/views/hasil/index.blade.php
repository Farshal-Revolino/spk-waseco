@extends('layouts.app')

@section('title', 'Hasil Perhitungan')
@section('page-title', 'Hasil Perhitungan Profile Matching')
@section('page-subtitle', 'Ranking dan hasil penilaian karyawan terbaik')

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

        .filter-card,
        .main-card,
        .stat-card,
        .validasi-card {
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

        .form-select {
            border-radius: 12px;
            padding: 10px 12px;
        }

        .btn {
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
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

        .bg-purple {
            background: linear-gradient(135deg, #6f42c1, #b197fc);
        }

        .winner-card {
            border: none;
            border-radius: 22px;
            padding: 24px;
            background: linear-gradient(135deg, #fff8e1, #ffffff);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
            border-left: 6px solid #ffc107;
            margin-bottom: 24px;
        }

        .winner-rank {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #ffc107, #ffd43b);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #212529;
            font-size: 28px;
            box-shadow: 0 8px 22px rgba(255, 193, 7, .35);
        }

        .winner-name {
            font-weight: 800;
            color: #212529;
            margin-bottom: 3px;
        }

        .winner-score {
            font-size: 30px;
            font-weight: 900;
            color: #0d6efd;
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

        .rank-badge {
            min-width: 48px;
            padding: 8px 10px;
            border-radius: 12px;
            font-weight: 800;
            display: inline-block;
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

        .score-pill {
            background: #e7f1ff;
            color: #0d6efd;
            border-radius: 12px;
            padding: 8px 12px;
            font-weight: 800;
            display: inline-block;
            min-width: 80px;
        }

        .aspect-pill {
            background: #f1f3f5;
            color: #495057;
            border-radius: 10px;
            padding: 7px 10px;
            font-weight: 700;
            font-size: 12px;
            display: inline-block;
            min-width: 55px;
        }

        .action-btn {
            border-radius: 10px;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 56px;
            color: #adb5bd;
        }

        .validasi-icon {
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
    </style>
@endsection

@section('content')

    @php
        $role = Auth::user()->role ?? null;

        // Sorting koleksi agar seragam
        $hasilCollection = collect($hasilList)->sortBy('ranking')->values();
        $totalHasil = $hasilCollection->count();
        $topHasil = $hasilCollection->first();

        $jumlahA = $hasilCollection->where('klasifikasi', 'A')->count();
        $jumlahB = $hasilCollection->where('klasifikasi', 'B')->count();
        $jumlahC = $hasilCollection->where('klasifikasi', 'C')->count();
        $jumlahD = $hasilCollection->where('klasifikasi', 'D')->count();

        $nilaiTertinggi = $topHasil ? $topHasil->nilai_total : 0;

        $badgeValidasi = [
            'menunggu' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
        ][$statusValidasi] ?? 'secondary';

        $labelValidasi = [
            'menunggu' => 'Menunggu Validasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ][$statusValidasi] ?? 'Tidak Diketahui';
    @endphp

    {{-- ─── PAGE HERO ─────────────────────────────────────────── --}}
    <div class="page-hero">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div>
                        <h4>Hasil Perhitungan Profile Matching</h4>
                        <p>Lihat ranking karyawan terbaik berdasarkan nilai akhir dan klasifikasi penilaian.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if($periode)
                    <span class="btn btn-light fw-bold">
                        <i class="bi bi-calendar-check me-2"></i>{{ $periode->nama }}
                    </span>
                @else
                    <span class="btn btn-light fw-bold">
                        <i class="bi bi-calendar-x me-2"></i>Belum Pilih Periode
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── FILTER PERIODE ─────────────────────────────────────── --}}
    <div class="card filter-card mb-4">
        <div class="card-body">
            <div class="row align-items-end g-3">
                <div class="col-lg-5">
                    <label for="periode_select" class="form-label fw-bold">Pilih Periode</label>
                    <select id="periode_select" class="form-select"
                        onchange="location.href='{{ route('hasil.index') }}?periode_id=' + this.value;">
                        <option value="">- Pilih Periode -</option>
                        @foreach($allPeriode as $p)
                            <option value="{{ $p->id }}" {{ $periode && $periode->id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->tahun }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-7 text-lg-end">
                    @if($periode)
                        {{-- Tombol Hitung: Muncul jika Admin, atau HRD saat belum ada data / ditolak --}}
                        @if($role === 'admin' || ($role === 'hrd' && (!$hasData || $statusValidasi === 'ditolak')))
                            <form action="{{ route('hasil.calculate') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Proses perhitungan akan menghapus hasil sebelumnya. Lanjutkan?')">
                                    <i class="bi bi-calculator me-1"></i>Proses Perhitungan
                                </button>
                            </form>
                        @endif

                        {{-- Tombol Export PDF: Hanya jika ada data yang boleh dilihat --}}
                        @if($totalHasil > 0 && ($role === 'direktur' || $statusValidasi === 'disetujui'))
                            <a href="{{ route('hasil.export-pdf') }}?periode_id={{ $periode->id }}" class="btn btn-danger ms-2"
                                target="_blank">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i>Export PDF
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ─── STATUS VALIDASI BAR ────────────────────────────────── --}}
    @if($periode)
        <div class="card validasi-card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="validasi-icon bg-{{ $badgeValidasi }}">
                        @if($statusValidasi === 'disetujui')
                            <i class="bi bi-check-circle-fill"></i>
                        @elseif($statusValidasi === 'ditolak')
                            <i class="bi bi-x-circle-fill"></i>
                        @else
                            <i class="bi bi-hourglass-split"></i>
                        @endif
                    </div>

                    <div>
                        <div class="text-muted small">Status Validasi Laporan</div>
                        <h5 class="fw-bold mb-1">{{ $periode->nama }} ({{ $periode->tahun }})</h5>

                        @if($validasi && $validasi->catatan_validasi)
                            <div class="text-muted small">
                                <strong>Catatan Direktur:</strong> "{{ $validasi->catatan_validasi }}"
                            </div>
                        @endif
                    </div>
                </div>

                <div class="text-md-end">
                    <span class="badge bg-{{ $badgeValidasi }} fs-6 px-3 py-2">
                        {{ $labelValidasi }}
                    </span>

                    @if($validasi)
                        <div class="text-muted small mt-2">
                            Divalidasi oleh: {{ $validasi->user->name ?? '-' }}<br>
                            Tanggal:
                            {{ $validasi->tanggal_validasi ? \Carbon\Carbon::parse($validasi->tanggal_validasi)->format('d M Y H:i') : '-' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Alert Khusus HRD/Admin jika ditolak --}}
        @if($statusValidasi === 'ditolak' && in_array($role, ['admin', 'hrd']))
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Laporan Ditolak:</strong> Nilai hasil akhir disembunyikan dari dashboard. Silakan lakukan perbaikan
                penilaian atau klik tombol <strong>Proses Perhitungan</strong> di atas untuk kalkulasi ulang.
            </div>
        @endif
    @endif

    {{-- ─── KONDISI AKSES KONTEN UTAMA ─────────────────────────── --}}
    @if($periode)
        @if($role === 'direktur' || $statusValidasi === 'disetujui')
            @if($totalHasil > 0)

                {{-- 1. Statistik Ringkasan Nilai --}}
                <div class="row g-3 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Total Dinilai</div>
                                    <h3 class="fw-bold mb-0">{{ $totalHasil }}</h3>
                                </div>
                                <div class="summary-icon bg-blue">
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
                                <div class="summary-icon bg-orange">
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
                                <div class="summary-icon bg-green">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Periode</div>
                                    <h5 class="fw-bold mb-0">{{ $periode->tahun }}</h5>
                                </div>
                                <div class="summary-icon bg-purple">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Winner Card --}}
                @if($topHasil)
                    <div class="winner-card">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="winner-rank">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    <div>
                                        <h4 class="winner-name">{{ $topHasil->karyawan->nama }}</h4>
                                        <div class="text-muted">
                                            Ranking #1 | NIK: {{ $topHasil->karyawan->nik }} | {{ $topHasil->karyawan->jabatan ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                <p class="winner-score">{{ number_format($topHasil->nilai_total, 2) }}</p>
                                <span class="badge bg-success fs-6">Kelas {{ $topHasil->klasifikasi }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 3. Tabel Klasifikasi Modern --}}
                <div class="card main-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0"><i class="bi bi-table me-2 text-primary"></i>Ranking Karyawan Terbaik</h5>
                            <small class="text-muted">{{ $periode->nama }}</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $totalHasil }} Data</span>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-modern datatable mb-0">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center">Rank</th>
                                        <th>Karyawan</th>
                                        <th>Jabatan</th>
                                        <th class="text-center">Teknis</th>
                                        <th class="text-center">Non Teknis</th>
                                        <th class="text-center">Kepribadian</th>
                                        <th class="text-center">Kepemimpinan</th>
                                        <th class="text-center">Nilai Total</th>
                                        <th class="text-center">Kelas</th>
                                        <th width="90" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hasilCollection as $hasil)
                                        <tr>
                                            <td class="text-center">
                                                <span
                                                    class="rank-badge 
                                                                                                                                                                                                                                        @if($hasil->ranking == 1) bg-warning text-dark
                                                                                                                                                                                                                                        @elseif($hasil->ranking == 2) bg-secondary text-white
                                                                                                                                                                                                                                        @elseif($hasil->ranking == 3) bg-danger text-white
                                                                                                                                                                                                                                        @else bg-light text-dark @endif">
                                                    @if($hasil->ranking <= 3) <i class="bi bi-trophy-fill me-1"></i> @endif
                                                    #{{ $hasil->ranking }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="employee-name">
                                                    {{ $hasil->karyawan->nama }}
                                                    @if($hasil->ranking == 1) <i class="bi bi-star-fill text-warning ms-1"></i> @endif
                                                </div>
                                                <div class="employee-sub">NIK: {{ $hasil->karyawan->nik }}</div>
                                            </td>
                                            <td>{{ $hasil->karyawan->jabatan ?? '-' }}</td>
                                            <td class="text-center"><span
                                                    class="aspect-pill">{{ number_format($hasil->nilai_teknis, 2) }}</span></td>
                                            <td class="text-center"><span
                                                    class="aspect-pill">{{ number_format($hasil->nilai_non_teknis, 2) }}</span></td>
                                            <td class="text-center"><span
                                                    class="aspect-pill">{{ number_format($hasil->nilai_kepribadian, 2) }}</span></td>
                                            <td class="text-center"><span
                                                    class="aspect-pill">{{ number_format($hasil->nilai_kepemimpinan, 2) }}</span></td>
                                            <td class="text-center"><span
                                                    class="score-pill">{{ number_format($hasil->nilai_total, 2) }}</span></td>
                                            <td class="text-center">
                                                <span
                                                    class="badge @if($hasil->klasifikasi == 'A') bg-success @elseif($hasil->klasifikasi == 'B') bg-primary @elseif($hasil->klasifikasi == 'C') bg-warning text-dark @else bg-danger @endif">
                                                    {{ $hasil->klasifikasi }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('hasil.show', $hasil->karyawan_id) }}?periode_id={{ $periode->id }}"
                                                    class="btn btn-info btn-sm action-btn" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- 4. Ringkasan Grid Bawah --}}
                <div class="row g-3 mt-3">
                    <div class="col-md-3">
                        <div class="card stat-card text-center py-2">
                            <div class="card-body">
                                <h3 class="text-success fw-bold mb-0">{{ $jumlahA }}</h3>
                                <p class="text-muted mb-0">Baik Sekali (A)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card text-center py-2">
                            <div class="card-body">
                                <h3 class="text-primary fw-bold mb-0">{{ $jumlahB }}</h3>
                                <p class="text-muted mb-0">Baik (B)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card text-center py-2">
                            <div class="card-body">
                                <h3 class="text-warning fw-bold mb-0">{{ $jumlahC }}</h3>
                                <p class="text-muted mb-0">Cukup (C)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card text-center py-2">
                            <div class="card-body">
                                <h3 class="text-danger fw-bold mb-0">{{ $jumlahD }}</h3>
                                <p class="text-muted mb-0">Kurang (D)</p>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- Data kosong murni (Belum dihitung oleh siapa pun) --}}
                <div class="card main-card">
                    <div class="empty-state">
                        <i class="bi bi-calculator"></i>
                        <h4 class="mt-3">Belum Ada Hasil Perhitungan</h4>
                        <p class="text-muted">Proses perhitungan nilai belum dijalankan untuk periode ini.</p>
                    </div>
                </div>
            @endif

        @else
            {{-- ── BLOCK PROTEKSI AMAN: Kondisi jika User adalah HRD/Admin & Status Menunggu/Ditolak ── --}}
            <div class="card main-card">
                <div class="empty-state py-5">
                    @if($statusValidasi === 'menunggu')
                        <i class="bi bi-hourglass-split text-warning"></i>
                        <h4 class="mt-3">Menunggu Validasi Direktur Utama</h4>
                        <p class="text-muted px-md-5">
                            Hasil perhitungan periode ini telah berhasil dikalkulasi. Namun, data nilai akhir disembunyikan sementara
                            sampai mendapatkan persetujuan/validasi resmi dari Direktur Utama.
                        </p>
                    @elseif($statusValidasi === 'ditolak')
                        <i class="bi bi-shield-x text-danger" style="font-size: 56px;"></i>
                        <h4 class="mt-3">Dashboard Nilai Ditutup (Laporan Ditolak)</h4>
                        <p class="text-muted px-md-5">
                            Direktur Utama menolak hasil penilaian pada periode ini. Seluruh rekap skor otomatis dibekukan demi
                            integritas data perusahaan.
                        </p>
                    @endif
                </div>
            </div>
        @endif

    @else
        {{-- Jika Belum Ada Periode yang Dipilih --}}
        <div class="card main-card">
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <h4 class="mt-3">Pilih Periode Terlebih Dahulu</h4>
                <p class="text-muted">Silakan tentukan periode penilaian pada menu dropdown di atas.</p>
            </div>
        </div>
    @endif

@endsection