@extends('layouts.app')

@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')
@section('page-subtitle', 'Form tambah data karyawan baru')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-plus me-2"></i>Form Tambah Karyawan
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
                                value="{{ old('nik') }}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                                name="jabatan" value="{{ old('jabatan') }}">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_kerja" class="form-label">Unit Kerja</label>
                            <select class="form-select @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
                                name="unit_kerja">
                                <option value="">Pilih Unit Kerja</option>
                                <option value="Teknis" {{ old('unit_kerja') == 'Teknis' ? 'selected' : '' }}>
                                    Teknis
                                </option>
                                <option value="Marketing" {{ old('unit_kerja') == 'Marketing' ? 'selected' : '' }}>
                                    Marketing
                                </option>
                                <option value="keuangan" {{ old('unit_kerja') == 'keuangan' ? 'selected' : '' }}>
                                    keuangan
                                </option>
                                <option value="Umum" {{ old('unit_kerja') == 'Umum' ? 'selected' : '' }}>
                                    Umum
                                </option>

                                <option value="Manager" {{ old('unit_kerja') == 'Manager' ? 'selected' : '' }}>
                                    Manager
                                </option>
                                <option value="Assisten Manager" {{ old('unit_kerja') == 'Assisten Manager' ? 'selected' : '' }}>
                                    Assisten Manager
                                </option>
                                <option value="Staff" {{ old('unit_kerja') == 'Staff' ? 'selected' : '' }}>
                                    Staff
                                </option>
                                <option value="Support Staff" {{ old('unit_kerja') == 'Support Staff' ? 'selected' : '' }}>
                                    Support Staff
                                </option>

                            </select>
                            @error('unit_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                                name="foto" accept="image/jpeg,image/png,image/jpg">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small> --}}

                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection