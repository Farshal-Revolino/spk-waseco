@extends('layouts.app')

@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')
@section('page-subtitle', 'Informasi lengkap data karyawan')

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
        }

        .page-hero h4 {
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-hero p {
            margin-bottom: 0;
            opacity: .9;
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

        .profile-card {
            border: 1px solid #eef2f7;
            border-radius: 20px;
            padding: 24px;
            background: #f8f9fb;
            height: 100%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .04);
        }

        .avatar-preview {
            width: 115px;
            height: 115px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
        }

        .avatar-placeholder {
            width: 115px;
            height: 115px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 52px;
            border: 5px solid #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
        }

        .profile-name {
            font-weight: 800;
            font-size: 21px;
            color: #212529;
            margin-top: 14px;
            margin-bottom: 4px;
        }

        .profile-sub {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            margin-top: 14px;
        }

        .status-active {
            background: #e9f7ef;
            color: #198754;
        }

        .status-inactive {
            background: #f1f3f5;
            color: #6c757d;
        }

        .detail-item {
            padding: 16px 0;
            border-bottom: 1px solid #edf0f3;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .detail-value {
            font-size: 15px;
            color: #212529;
            font-weight: 700;
            margin-bottom: 0;
        }

        .detail-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #e7f1ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
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
                        <i class="bi bi-person-vcard"></i>
                    </div>
                    <div>
                        <h4>Detail Karyawan</h4>
                        <p>Informasi lengkap data karyawan PT Waseco Tirta.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('karyawan.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="profile-card text-center">
                <div class="d-flex justify-content-center">
                    @if($karyawan->foto)
                        <img src="{{ asset('uploads/karyawan/' . $karyawan->foto) }}" alt="{{ $karyawan->nama }}"
                            class="avatar-preview">
                    @else
                        <div class="avatar-placeholder">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    @endif
                </div>

                <div class="profile-name">{{ $karyawan->nama }}</div>
                <p class="profile-sub">NIK: {{ $karyawan->nik }}</p>

                @if($karyawan->status == 'aktif')
                    <span class="status-badge status-active">
                        <i class="bi bi-check-circle me-1"></i>Aktif
                    </span>
                @else
                    <span class="status-badge status-inactive">
                        <i class="bi bi-dash-circle me-1"></i>Non-Aktif
                    </span>
                @endif

                <hr>

                <div class="d-grid gap-2">
                    <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i>Edit Data
                    </a>

                    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card main-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Informasi Karyawan
                    </h5>
                    <small class="text-muted">Detail data karyawan yang tersimpan pada sistem</small>
                </div>

                <div class="card-body p-4">

                    <div class="detail-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="detail-icon">
                                <i class="bi bi-credit-card-2-front"></i>
                            </div>
                            <div>
                                <div class="detail-label">NIK</div>
                                <p class="detail-value">{{ $karyawan->nik }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="detail-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <div class="detail-label">Nama Lengkap</div>
                                <p class="detail-value">{{ $karyawan->nama }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="detail-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div>
                                <div class="detail-label">Jabatan</div>
                                <p class="detail-value">{{ $karyawan->jabatan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="detail-icon">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <div>
                                <div class="detail-label">Unit Kerja</div>
                                <p class="detail-value">{{ $karyawan->unit_kerja ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="detail-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <div class="detail-label">Tanggal Masuk</div>
                                <p class="detail-value">
                                    {{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="detail-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div>
                                <div class="detail-label">Status</div>
                                <p class="detail-value">
                                    @if($karyawan->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>

                    <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection