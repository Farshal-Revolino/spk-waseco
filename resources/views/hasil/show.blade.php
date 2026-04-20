@extends('layouts.app')

@section('title', 'Detail Perhitungan')
@section('page-title', 'Detail Perhitungan')
@section('page-subtitle', 'Breakdown Profile Matching - ' . $karyawan->nama)

@section('content')

    {{-- INFO KARYAWAN --}}
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <div style="width:55px;height:55px;background:linear-gradient(135deg,#1a56a0,#00aaff);
                                    border-radius:50%;display:flex;align-items:center;justify-content:center;
                                    color:white;font-size:1.5rem;margin:0 auto;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>
                <div class="col-md-7">
                    <h5 class="mb-1 fw-bold">{{ $karyawan->nama }}</h5>
                    <p class="mb-0 text-muted" style="font-size:0.88rem;">
                        <i class="bi bi-credit-card me-1"></i>{{ $karyawan->nik }}
                        &nbsp;|&nbsp;
                        <i class="bi bi-briefcase me-1"></i>{{ $karyawan->jabatan ?? '-' }}
                        &nbsp;|&nbsp;
                        <i class="bi bi-building me-1"></i>{{ $karyawan->unit_kerja ?? '-' }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-inline-block text-center bg-light rounded-3 px-4 py-2">
                        <div style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:1px;">Ranking
                        </div>
                        <div style="font-size:2rem;font-weight:800;color:#1a56a0;line-height:1;">#{{ $hasil->ranking }}
                        </div>
                        <span class="badge bg-{{ $hasil->klasifikasi_badge }}">
                            Kelas {{ $hasil->klasifikasi }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NILAI TOTAL & PER KRITERIA --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <div style="font-size:0.8rem;color:#64748b;text-transform:uppercase;letter-spacing:1px;" class="mb-2">
                        NILAI TOTAL
                    </div>
                    <div style="font-size:3rem;font-weight:800;color:#1a56a0;line-height:1;">
                        {{ number_format($hasil->nilai_total, 2) }}
                    </div>
                    <div style="font-size:0.8rem;color:#94a3b8;" class="mt-1">dari maksimal 320</div>
                    <div class="progress mt-3" style="height:8px;">
                        <div class="progress-bar bg-primary" style="width:{{ ($hasil->nilai_total / 320) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-bar-chart me-2"></i>Nilai per Aspek
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 text-center" style="background:#eff6ff;border:1px solid #bfdbfe;">
                                <div style="font-size:0.75rem;color:#3b82f6;font-weight:600;">TEKNIS</div>
                                <div style="font-size:1.6rem;font-weight:700;color:#1d4ed8;">
                                    {{ number_format($hasil->nilai_teknis, 2) }}
                                </div>
                                <div style="font-size:0.72rem;color:#93c5fd;">Bobot 35%</div>
                                <div class="mt-1 text-start" style="font-size:0.72rem;color:#64748b;">
                                    NCF: {{ $hasil->ncf_teknis }} | NSF: {{ $hasil->nsf_teknis }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 text-center" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                <div style="font-size:0.75rem;color:#16a34a;font-weight:600;">NON TEKNIS</div>
                                <div style="font-size:1.6rem;font-weight:700;color:#15803d;">
                                    {{ number_format($hasil->nilai_non_teknis, 2) }}
                                </div>
                                <div style="font-size:0.72rem;color:#86efac;">Bobot 25%</div>
                                <div class="mt-1 text-start" style="font-size:0.72rem;color:#64748b;">
                                    NCF: {{ $hasil->ncf_non_teknis }} | NSF: {{ $hasil->nsf_non_teknis }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 text-center" style="background:#fffbeb;border:1px solid #fde68a;">
                                <div style="font-size:0.75rem;color:#d97706;font-weight:600;">KEPRIBADIAN</div>
                                <div style="font-size:1.6rem;font-weight:700;color:#b45309;">
                                    {{ number_format($hasil->nilai_kepribadian, 2) }}
                                </div>
                                <div style="font-size:0.72rem;color:#fcd34d;">Bobot 25%</div>
                                <div class="mt-1 text-start" style="font-size:0.72rem;color:#64748b;">
                                    NCF: {{ $hasil->ncf_kepribadian }} | NSF: {{ $hasil->nsf_kepribadian }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 text-center" style="background:#fdf4ff;border:1px solid #e9d5ff;">
                                <div style="font-size:0.75rem;color:#9333ea;font-weight:600;">KEPEMIMPINAN</div>
                                <div style="font-size:1.6rem;font-weight:700;color:#7e22ce;">
                                    {{ number_format($hasil->nilai_kepemimpinan, 2) }}
                                </div>
                                <div style="font-size:0.72rem;color:#d8b4fe;">Bobot 15%</div>
                                <div class="mt-1 text-start" style="font-size:0.72rem;color:#64748b;">
                                    NCF: {{ $hasil->ncf_kepemimpinan }} | NSF: {{ $hasil->nsf_kepemimpinan }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL PER KRITERIA --}}
    @foreach($detail_kriteria as $kriteria)
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bookmark-fill me-2" style="color:#1a56a0;"></i>{{ $kriteria['nama'] }}</span>
                <span class="badge" style="background:#1a56a0;">Bobot {{ $kriteria['bobot'] }}%</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Sub Kriteria</th>
                                <th width="110" class="text-center">Tipe</th>
                                <th width="110" class="text-center">Nilai Aktual</th>
                                <th width="110" class="text-center">Nilai Ideal</th>
                                <th width="90" class="text-center">GAP</th>
                                <th width="90" class="text-center">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriteria['sub_kriteria'] as $sub)
                                <tr>
                                    <td>{{ $sub['nama'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $sub['tipe'] == 'core' ? 'primary' : 'warning text-dark' }}">
                                            {{ $sub['tipe'] == 'core' ? 'Core' : 'Secondary' }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold">{{ $sub['nilai'] }}</td>
                                    <td class="text-center text-muted">{{ $sub['nilai_ideal'] }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $sub['gap'] == 0 ? 'success' : ($sub['gap'] > 0 ? 'info' : 'danger') }}">
                                            {{ $sub['gap'] > 0 ? '+' : '' }}{{ $sub['gap'] }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold">{{ $sub['bobot'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    {{-- KEMBALI --}}
    <div class="text-center pb-4">
        <a href="{{ route('hasil.index') }}?periode_id={{ $hasil->periode_id }}" class="btn btn-secondary px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Hasil
        </a>
    </div>

@endsection