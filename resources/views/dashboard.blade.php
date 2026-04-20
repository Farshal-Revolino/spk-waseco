@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan dan Statistik Penilaian Karyawan')

@section('content')
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card blue">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1" style="color: rgb(0, 0, 0); opacity: 0.9;">Total Karyawan</p>
                            <h3 class="mb-0" style="color: rgb(0, 0, 0);">{{ $totalKaryawan }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: rgb(0, 0, 0); opacity: 0.8;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card green">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1" style="color: rgb(0, 0, 0); opacity: 0.9;">Total Kriteria</p>
                            <h3 class="mb-0" style="color: rgb(0, 0, 0);">{{ $totalKriteria }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: rgb(0, 0, 0); opacity: 0.8;">
                            <i class="bi bi-list-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card orange">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1" style="color: rgb(0, 0, 0); opacity: 0.9;">Total Periode</p>
                            <h3 class="mb-0" style="color: rgb(0, 0, 0);">{{ $totalPeriode }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: rgb(0, 0, 0); opacity: 0.8;">
                            <i class="bi bi-calendar3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card purple">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1" style="color: rgb(0, 0, 0); opacity: 0.9;">Data Penilaian</p>
                            <h3 class="mb-0" style="color: rgb(0, 0, 0);">{{ $totalPenilaian }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: rgb(0, 0, 0); opacity: 0.8;">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Periode Aktif Info -->
    @if($periodeAktif)
        <div class="alert alert-info border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Periode Penilaian Aktif:</strong> {{ $periodeAktif->nama }} ({{ $periodeAktif->tahun }})
                    <br>
                    <small>{{ $periodeAktif->tanggal_mulai->format('d M Y') }} -
                        {{ $periodeAktif->tanggal_selesai->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning border-0" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada periode penilaian aktif.
        </div>
    @endif

    <div class="row">
        <!-- Top 5 Karyawan Terbaik -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-trophy me-2"></i>Top 5 Karyawan Terbaik
                    @if($periodeAktif)
                        <small class="text-muted">({{ $periodeAktif->nama }})</small>
                    @endif
                </div>
                <div class="card-body">
                    @if(count($topKaryawan) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">Rank</th>
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
                                            <td>{{ $hasil->karyawan->nik }}</td>
                                            <td><strong>{{ $hasil->karyawan->nama }}</strong></td>
                                            <td>{{ $hasil->karyawan->jabatan ?? '-' }}</td>
                                            <td class="text-end">
                                                <strong>{{ number_format($hasil->nilai_total, 2) }}</strong>
                                            </td>
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
                        <div class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
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
        {{--
        {{-- <!-- Distribusi Klasifikasi -->
        {{-- <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pie-chart me-2"></i>Distribusi Klasifikasi
                </div>
                <div class="card-body">
                    @if($periodeAktif && count($topKaryawan) > 0)
                    <canvas id="chartKlasifikasi" height="250"></canvas>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-pie-chart" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Belum ada data untuk ditampilkan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Quick Actions -->
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
                                <a href="#" class="btn btn-outline-secondary w-100 mb-2 disabled">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Cetak Laporan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if($periodeAktif && count($topKaryawan) > 0)
        <script>
            const ctx = document.getElementById('chartKlasifikasi');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($chartKlasifikasi['labels']) !!},
                        datasets: [{
                            data: {!! json_encode($chartKlasifikasi['data']) !!},
                            backgroundColor: ['#198754', '#0d6efd', '#ffc107', '#dc3545'],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: { size: 12 }
                                }
                            }
                        }
                    }
                });
            }
        </script>
    @endif
@endsection