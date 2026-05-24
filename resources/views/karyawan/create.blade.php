@extends('layouts.app')

@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')
@section('page-subtitle', 'Form tambah data karyawan baru')

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

    .info-card {
        border: 1px solid #eef2f7;
        border-radius: 20px;
        padding: 24px;
        background: #f8f9fb;
        height: 100%;
        box-shadow: 0 8px 24px rgba(0,0,0,.04);
    }

    .info-icon {
        width: 90px;
        height: 90px;
        border-radius: 24px;
        background: linear-gradient(135deg, #0d6efd, #4dabf7);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        margin: 0 auto 18px;
        box-shadow: 0 8px 24px rgba(13, 110, 253, .22);
    }

    .info-title {
        font-weight: 800;
        color: #212529;
        font-size: 18px;
        margin-bottom: 8px;
    }

    .info-text {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 18px;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #edf0f3;
        color: #495057;
        font-size: 14px;
    }

    .info-list li:last-child {
        border-bottom: none;
    }

    .info-list i {
        color: #0d6efd;
        font-size: 18px;
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
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <div>
                    <h4>Tambah Data Karyawan</h4>
                    <p>Tambahkan data karyawan baru yang akan digunakan dalam proses penilaian karyawan terbaik.</p>
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
        <div class="info-card text-center">
            <div class="info-icon">
                <i class="bi bi-person-vcard"></i>
            </div>

            <div class="info-title">Informasi Pengisian</div>
            <p class="info-text">
                Pastikan data karyawan diisi dengan benar agar dapat digunakan pada proses penilaian.
            </p>

            <ul class="info-list text-start">
                <li>
                    <i class="bi bi-check-circle"></i>
                    NIK dan nama wajib diisi.
                </li>
                <li>
                    <i class="bi bi-check-circle"></i>
                    Jabatan dan unit kerja membantu identifikasi karyawan.
                </li>
                <li>
                    <i class="bi bi-check-circle"></i>
                    Status aktif digunakan untuk data penilaian.
                </li>
                <li>
                    <i class="bi bi-check-circle"></i>
                    Data dapat diedit kembali setelah disimpan.
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card main-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                    Form Tambah Karyawan
                </h5>
                <small class="text-muted">Lengkapi data karyawan dengan benar</small>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                                       value="{{ old('nik') }}"
                                       placeholder="Masukkan NIK"
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
                                       value="{{ old('nama') }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>

                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="section-title">Informasi Pekerjaan</div>
                        <div class="section-subtitle">Data jabatan, unit kerja, tanggal masuk, dan status karyawan</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text"
                                       class="form-control @error('jabatan') is-invalid @enderror"
                                       id="jabatan"
                                       name="jabatan"
                                       value="{{ old('jabatan') }}"
                                       placeholder="Contoh: Marketing">

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
                                        {{ old('unit_kerja') == 'Teknis/Marketing/Keuangan/Umum' ? 'selected' : '' }}>
                                        Teknis/Marketing/Keuangan/Umum
                                    </option>

                                    <option value="Dir/Man/Ass.Man/Staff/Supp.Staff"
                                        {{ old('unit_kerja') == 'Dir/Man/Ass.Man/Staff/Supp.Staff' ? 'selected' : '' }}>
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
                                       value="{{ old('tanggal_masuk') }}">

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
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>

                                    <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>
                                        Non-Aktif
                                    </option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Jika nanti fitur foto ingin diaktifkan, buka komentar bagian ini --}}
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
                            <i class="bi bi-save me-1"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection