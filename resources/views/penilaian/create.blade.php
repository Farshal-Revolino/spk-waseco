@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page-title', 'Input Penilaian Karyawan')
@section('page-subtitle', 'Form input penilaian berdasarkan kriteria')

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

        .employee-card {
            border: 1px solid #eef2f7;
            border-radius: 20px;
            background: #f8f9fb;
            padding: 22px;
            height: 100%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .04);
        }

        .employee-avatar {
            width: 78px;
            height: 78px;
            border-radius: 22px;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            box-shadow: 0 8px 24px rgba(13, 110, 253, .20);
            margin-bottom: 14px;
        }

        .employee-name {
            font-size: 20px;
            font-weight: 800;
            color: #212529;
            margin-bottom: 4px;
        }

        .employee-sub {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .info-line {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #edf0f3;
            font-size: 14px;
        }

        .info-line:last-child {
            border-bottom: none;
        }

        .info-line i {
            color: #0d6efd;
            font-size: 18px;
            margin-top: 2px;
        }

        .period-badge {
            background: #e7f1ff;
            color: #0d6efd;
            border-radius: 14px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
            width: 100%;
        }

        .criteria-card {
            border: 1px solid #eef2f7;
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 18px;
            background: #fff;
        }

        .criteria-header {
            background: #f8f9fb;
            border-bottom: 1px solid #eef2f7;
            padding: 16px 18px;
        }

        .criteria-title {
            font-weight: 800;
            color: #212529;
            margin-bottom: 3px;
        }

        .criteria-subtitle {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 0;
        }

        .criteria-body {
            padding: 16px 18px;
        }

        .sub-item {
            border: 1px solid #edf0f3;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
            transition: .2s;
            background: #fff;
        }

        .sub-item:hover {
            border-color: #cfe2ff;
            box-shadow: 0 8px 20px rgba(13, 110, 253, .06);
        }

        .sub-code {
            display: inline-block;
            min-width: 54px;
            text-align: center;
            padding: 6px 10px;
            border-radius: 10px;
            background: #e7f1ff;
            color: #0d6efd;
            font-weight: 800;
            font-size: 13px;
            margin-right: 8px;
        }

        .factor-badge {
            border-radius: 10px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-core {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .badge-secondary {
            background: #fff4db;
            color: #b7791f;
        }

        .target-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 8px;
        }

        .nilai-input {
            border-radius: 14px;
            padding: 12px;
            font-size: 18px;
            font-weight: 800;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .nilai-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .15);
        }

        .quick-target {
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 10px;
        }

        .note-box {
            border: none;
            border-radius: 18px;
            background: #e7f1ff;
            color: #084298;
            padding: 18px;
        }

        .btn {
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .form-footer {
            background: #fff;
            border-top: 1px solid #edf0f3;
            padding: 18px 22px;
        }

        @media (max-width: 768px) {
            .nilai-input {
                margin-top: 12px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-hero">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div>
                        <h4>Input Penilaian Karyawan</h4>
                        <p>Masukkan nilai karyawan berdasarkan kriteria dan target ideal metode Profile Matching.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('penilaian.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-4">
            <div class="employee-card">
                <div class="employee-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="employee-name">{{ $karyawan->nama }}</div>
                <p class="employee-sub">Data karyawan yang sedang dinilai</p>

                <div class="info-line">
                    <i class="bi bi-credit-card-2-front"></i>
                    <div>
                        <strong>NIK</strong><br>
                        <span class="text-muted">{{ $karyawan->nik }}</span>
                    </div>
                </div>

                <div class="info-line">
                    <i class="bi bi-briefcase"></i>
                    <div>
                        <strong>Jabatan</strong><br>
                        <span class="text-muted">{{ $karyawan->jabatan ?? '-' }}</span>
                    </div>
                </div>

                <div class="info-line">
                    <i class="bi bi-diagram-3"></i>
                    <div>
                        <strong>Unit Kerja</strong><br>
                        <span class="text-muted">{{ $karyawan->unit_kerja ?? '-' }}</span>
                    </div>
                </div>

                <hr>

                <div class="period-badge">
                    <i class="bi bi-calendar-check me-2"></i>
                    Periode: {{ $periodeAktif->nama }}
                </div>

                <div class="note-box mt-3">
                    <strong><i class="bi bi-info-circle me-1"></i>Skala Penilaian</strong><br>
                    <small>
                        A = 16–20 Baik Sekali<br>
                        B = 11–15 Baik<br>
                        C = 6–10 Cukup<br>
                        D = 0–5 Kurang
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
                @csrf
                <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                <div class="card main-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check me-2 text-primary"></i>
                            Form Penilaian
                        </h5>
                        <small class="text-muted">Nilai dapat diisi dari 0 sampai 20</small>
                    </div>

                    <div class="card-body p-4">
                        @foreach($kriteriaList as $kriteria)
                            <div class="criteria-card">
                                <div class="criteria-header">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                        <div>
                                            <div class="criteria-title">
                                                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                                                {{ $kriteria->kode }} - {{ $kriteria->nama }}
                                            </div>
                                            <p class="criteria-subtitle">Isi nilai pada setiap sub kriteria berikut.</p>
                                        </div>

                                        <span class="badge bg-primary rounded-pill">
                                            Bobot {{ $kriteria->bobot }}%
                                        </span>
                                    </div>
                                </div>

                                <div class="criteria-body">
                                    @foreach($kriteria->subKriteria as $subKriteria)
                                        @php
                                            $nilaiLama = isset($existingPenilaian[$subKriteria->id])
                                                ? $existingPenilaian[$subKriteria->id]->nilai
                                                : '';

                                            $targetIdeal = $subKriteria->profilIdeal
                                                ? $subKriteria->profilIdeal->nilai_ideal
                                                : '';
                                        @endphp

                                        <div class="sub-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-1">
                                                        <span class="sub-code">{{ $subKriteria->kode }}</span>
                                                        <strong>{{ $subKriteria->nama }}</strong>
                                                    </div>

                                                    <div class="mt-2">
                                                        @if($subKriteria->tipe == 'core')
                                                            <span class="factor-badge badge-core">
                                                                Core Factor
                                                            </span>
                                                        @else
                                                            <span class="factor-badge badge-secondary">
                                                                Secondary Factor
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($subKriteria->profilIdeal)
                                                        <div class="target-text">
                                                            <i class="bi bi-bullseye me-1"></i>
                                                            Target Ideal: <strong>{{ $targetIdeal }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label small text-muted mb-1">
                                                        Nilai Aktual
                                                    </label>

                                                    <input type="number" class="form-control nilai-input"
                                                        name="penilaian[{{ $subKriteria->id }}]" id="nilai_{{ $subKriteria->id }}"
                                                        min="0" max="20" value="{{ $nilaiLama }}" placeholder="0-20" required>

                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <small class="text-muted">0 sampai 20</small>

                                                        @if($targetIdeal !== '')
                                                            <button type="button" class="btn btn-outline-primary btn-sm quick-target"
                                                                data-target="{{ $targetIdeal }}"
                                                                data-input="nilai_{{ $subKriteria->id }}">
                                                                Isi Ideal
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="note-box">
                            <strong>Keterangan:</strong><br>
                            <small>
                                Core Factor merupakan faktor utama dalam penilaian, sedangkan Secondary Factor merupakan
                                faktor pendukung.
                                Nilai target ideal digunakan sebagai standar pembanding dalam proses perhitungan GAP.
                            </small>
                        </div>
                    </div>

                    <div class="form-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Penilaian
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.quick-target').forEach(button => {
            button.addEventListener('click', function () {
                const inputId = this.getAttribute('data-input');
                const target = this.getAttribute('data-target');
                const input = document.getElementById(inputId);

                if (input) {
                    input.value = target;
                    input.classList.remove('is-invalid');
                }
            });
        });

        document.getElementById('formPenilaian').addEventListener('submit', function (e) {
            const inputs = document.querySelectorAll('input[type="number"]');
            let valid = true;

            inputs.forEach(input => {
                const nilai = parseInt(input.value);

                if (input.value === '' || isNaN(nilai) || nilai < 0 || nilai > 20) {
                    valid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Mohon isi semua nilai dengan angka antara 0 sampai 20!');
            }
        });
    </script>
@endsection