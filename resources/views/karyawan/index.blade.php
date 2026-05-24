@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Manajemen Data Karyawan PT Waseco Tirta')

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

        .page-hero h4 {
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-hero p {
            margin-bottom: 0;
            opacity: .9;
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
        }

        .stat-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
            transition: .25s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .10);
        }

        .stat-icon {
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

        .bg-purple {
            background: linear-gradient(135deg, #6f42c1, #b197fc);
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

        .avatar-karyawan {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eef2f7;
        }

        .avatar-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            border: 2px solid #eef2f7;
        }

        .employee-name {
            font-weight: 700;
            color: #212529;
        }

        .employee-sub {
            font-size: 12px;
            color: #6c757d;
        }

        .badge-soft-success {
            background: #e9f7ef;
            color: #198754;
            border-radius: 10px;
            padding: 7px 10px;
        }

        .badge-soft-secondary {
            background: #f1f3f5;
            color: #6c757d;
            border-radius: 10px;
            padding: 7px 10px;
        }

        .action-btn {
            border-radius: 10px;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 55px 20px;
        }

        .empty-state i {
            font-size: 52px;
            color: #adb5bd;
        }
    </style>
@endsection

@section('content')
    @php
        $totalKaryawan = $karyawan->count();
        $totalAktif = $karyawan->where('status', 'aktif')->count();
        $totalNonAktif = $karyawan->where('status', 'non-aktif')->count();
        $totalUnit = $karyawan->pluck('unit_kerja')->filter()->unique()->count();
    @endphp

    <div class="page-hero">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h4>Data Karyawan</h4>
                        <p>Kelola data karyawan yang akan digunakan dalam proses penilaian karyawan terbaik.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('karyawan.create') }}" class="btn btn-light fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Karyawan
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Karyawan</div>
                        <h3 class="fw-bold mb-0">{{ $totalKaryawan }}</h3>
                    </div>
                    <div class="stat-icon bg-blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Karyawan Aktif</div>
                        <h3 class="fw-bold mb-0">{{ $totalAktif }}</h3>
                    </div>
                    <div class="stat-icon bg-green">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Non-Aktif</div>
                        <h3 class="fw-bold mb-0">{{ $totalNonAktif }}</h3>
                    </div>
                    <div class="stat-icon bg-orange">
                        <i class="bi bi-person-dash-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Unit Kerja</div>
                        <h3 class="fw-bold mb-0">{{ $totalUnit }}</h3>
                    </div>
                    <div class="stat-icon bg-purple">
                        <i class="bi bi-diagram-3-fill"></i>
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
                    Daftar Karyawan
                </h5>
                <small class="text-muted">Data karyawan PT Waseco Tirta</small>
            </div>

            <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah
            </a>
        </div>

        <div class="card-body p-0">
            @if($karyawan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-modern datatable mb-0">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Karyawan</th>
                                <th>NIK</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th width="130" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($karyawan as $index => $k)
                                <tr>
                                    <td class="fw-bold text-muted">{{ $index + 1 }}</td>

                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($k->foto)
                                                <img src="{{ asset('uploads/karyawan/' . $k->foto) }}" alt="{{ $k->nama }}"
                                                    class="avatar-karyawan">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="employee-name">{{ $k->nama }}</div>
                                                <div class="employee-sub">Karyawan PT Waseco Tirta</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="fw-bold">{{ $k->nik }}</span>
                                    </td>

                                    <td>
                                        {{ $k->jabatan ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $k->unit_kerja ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $k->tanggal_masuk ? $k->tanggal_masuk->format('d M Y') : '-' }}
                                    </td>

                                    <td>
                                        @if($k->status == 'aktif')
                                            <span class="badge badge-soft-success">
                                                <i class="bi bi-check-circle me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-soft-secondary">
                                                <i class="bi bi-dash-circle me-1"></i>Non-Aktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-warning btn-sm action-btn"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirmDelete(this)">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm action-btn" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5 class="mt-3">Belum ada data karyawan</h5>
                    <p class="text-muted">Silakan tambahkan data karyawan terlebih dahulu.</p>
                    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Karyawan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection