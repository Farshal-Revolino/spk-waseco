@extends('layouts.app')

@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')
@section('page-subtitle', 'Form edit data karyawan')

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
        background: rgba(255,255,255,0.12);
        right: -70px;
        top: -80px;
    }

    .hero-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255,255,255,0.16);
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
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .main-card .card-header {
        background: #fff;
        border-bottom: 1px solid #edf0f3;
        padding: 18px 22px;
    }

    .form-label {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 10px 12px;
        border: 1px solid #dee2e6;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .15);
    }

    .profile-card {
        border: 1px solid #eef2f7;
        border-radius: 18px;
        padding: 20px;
        background: #f8f9fb;
        height: 100%;
    }

    .avatar-preview {
        width: 95px;
        height: 95px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,.10);
    }

    .avatar-placeholder {
        width: 95px;
        height: 95px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd, #4dabf7);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        border: 4px solid #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,.10);
    }

    .profile-name {
        font-weight: 800;
        font-size: 18px;
        color: #212529;
        margin-top: 12px;
        margin-bottom: 4px;
    }

    .profile-sub {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 0;
    }

    .info-badge {
        display: inline-block;
        padding: 7px 10px;
        border-radius: 10px;
        background: #e7f1ff;
        color: #0d6efd;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .btn {
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
    }

    .section-title {
        font-weight: 800;
        color: #212529;
        margin-bottom: 4px;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 18px;
    }
</style>
@endsection

@section('content')

<div class="page-hero">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h4>Edit Data Karyawan</h4>
                    <p>Perbarui informasi karyawan yang digunakan dalam proses penilaian karyawan terbaik.</p>
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
                    <img src="{{ asset('uploads/karyawan/' . $karyawan->foto) }}"
                         alt="{{ $karyawan->nama }}"
                         class="avatar-preview">
                @else
                    <div class="avatar-placeholder">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
            </div>

            <div class="profile-name">{{ $karyawan->nama }}</div>
            <p class="profile-sub">NIK: {{ $karyawan->nik }}</p>

            <div class="info-badge">
                <i class="bi bi-briefcase me-1"></i>
                {{ $karyawan->jabatan ?? 'Jabatan belum diisi' }}
            </div>

            <hr>

            <div class="text-start">
                <p class="mb-2">
                    <i class="bi bi-diagram-3 text-primary me-2"></i>
                    <strong>Unit:</strong> {{ $karyawan->unit_kerja ?? '-' }}
                </p>

                <p class="mb-2">
                    <i class="bi bi-calendar-check text-primary me-2"></i>
                    <strong>Tanggal Masuk:</strong>
                    {{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('d M Y') : '-' }}
                </p>

                <p class="mb-0">
                    <i class="bi bi-check-circle text-primary me-2"></i>
                    <strong>Status:</strong>
                    @if($karyawan->status == 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Non-Aktif</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card main-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                    Form Edit Karyawan
                </h5>
                <small class="text-muted">Lengkapi data karyawan dengan benar</small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <div class="section-title">Informasi Utama</div>
                        <div class="section-subtitle">Data dasar karyawan PT Waseco Tirta</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('nik') is-invalid @enderror"
                                       id="nik"
                                       name="nik"
                                       value="{{ old('nik', $karyawan->nik) }}"
                                       required>

                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       id="nama"
                                       name="nama"
                                       value="{{ old('nama', $karyawan->nama) }}"
                                       required>

                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="section-title">Informasi Pekerjaan</div>
                        <div class="section-subtitle">Data jabatan, unit kerja, dan status karyawan</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text"
                                       class="form-control @error('jabatan') is-invalid @enderror"
                                       id="jabatan"
                                       name="jabatan"
                                       value="{{ old('jabatan', $karyawan->jabatan) }}">

                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                <select class="form-select @error('unit_kerja') is-invalid @enderror"
                                        id="unit_kerja"
                                        name="unit_kerja">
                                    <option value="">Pilih Unit Kerja</option>

                                    <option value="Teknis/Marketing/Keuangan/Umum"
                                        {{ old('unit_kerja', $karyawan->unit_kerja) == 'Teknis/Marketing/Keuangan/Umum' ? 'selected' : '' }}>
                                        Teknis/Marketing/Keuangan/Umum
                                    </option>

                                    <option value="Dir/Man/Ass.Man/Staff/Supp.Staff"
                                        {{ old('unit_kerja', $karyawan->unit_kerja) == 'Dir/Man/Ass.Man/Staff/Supp.Staff' ? 'selected' : '' }}>
                                        Dir/Man/Ass.Man/Staff/Supp.Staff
                                    </option>
                                </select>

                                @error('unit_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                <input type="date"
                                       class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                       id="tanggal_masuk"
                                       name="tanggal_masuk"
                                       value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('Y-m-d') : '') }}">

                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="aktif" {{ old('status', $karyawan->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>

                                    <option value="non-aktif" {{ old('status', $karyawan->status) == 'non-aktif' ? 'selected' : '' }}>
                                        Non-Aktif
                                    </option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Jika nanti foto ingin diaktifkan, buka komentar bagian ini --}}
                    {{--
                    <div class="mb-4">
                        <div class="section-title">Foto Karyawan</div>
                        <div class="section-subtitle">Upload foto dengan format JPG, JPEG, atau PNG</div>

                        <label for="foto" class="form-label">Foto</label>
                        <input type="file"
                               class="form-control @error('foto') is-invalid @enderror"
                               id="foto"
                               name="foto"
                               accept="image/jpeg,image/png,image/jpg">

                        <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>

                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    --}}

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection