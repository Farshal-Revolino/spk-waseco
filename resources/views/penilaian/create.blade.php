@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page-title', 'Input Penilaian Karyawan')
@section('page-subtitle', 'Form input penilaian berdasarkan kriteria')

@section('styles')
<style>
    .criteria-section {
        background: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    
    .sub-criteria-item {
        background: white;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <!-- Karyawan Info Card -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-1">{{ $karyawan->nama }}</h5>
                        <p class="mb-0 text-muted">
                            <strong>NIK:</strong> {{ $karyawan->nik }} | 
                            <strong>Jabatan:</strong> {{ $karyawan->jabatan ?? '-' }} |
                            <strong>Unit:</strong> {{ $karyawan->unit_kerja ?? '-' }}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-info">Periode: {{ $periodeAktif->nama }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Penilaian -->
        <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
            @csrf
            <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-clipboard-check me-2"></i>Form Penilaian Karyawan
                    <br><small>Skala Penilaian: A (16-20) | B (11-15) | C (6-10) | D (0-5)</small>
                </div>
                <div class="card-body">
                    @foreach($kriteriaList as $kriteria)
                    <div class="criteria-section">
                        <h6 class="mb-3">
                            <i class="bi bi-bookmark-fill me-2"></i>
                            {{ $kriteria->kode }} - {{ $kriteria->nama }}
                            <span class="badge bg-secondary">Bobot: {{ $kriteria->bobot }}%</span>
                        </h6>

                        @foreach($kriteria->subKriteria as $subKriteria)
                        <div class="sub-criteria-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <strong>{{ $subKriteria->kode }}</strong>
                                        {{ $subKriteria->nama }}
                                        <span class="badge bg-{{ $subKriteria->tipe == 'core' ? 'primary' : 'warning' }}">
                                            {{ $subKriteria->tipe == 'core' ? 'Core Factor' : 'Secondary Factor' }}
                                        </span>
                                    </label>
                                    @if($subKriteria->profilIdeal)
                                    <small class="text-muted d-block">
                                        <i class="bi bi-target me-1"></i>Target Ideal: {{ $subKriteria->profilIdeal->nilai_ideal }}
                                    </small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap gap-2">
                                        @for($nilai = 0; $nilai <= 20; $nilai += 5)
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="penilaian[{{ $subKriteria->id }}]" 
                                                   id="nilai_{{ $subKriteria->id }}_{{ $nilai }}" 
                                                   value="{{ $nilai }}"
                                                   {{ isset($existingPenilaian[$subKriteria->id]) && $existingPenilaian[$subKriteria->id]->nilai == $nilai ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label" for="nilai_{{ $subKriteria->id }}_{{ $nilai }}">
                                                {{ $nilai }}
                                            </label>
                                        </div>
                                        @endfor
                                    </div>
                                    <small class="text-muted">Pilih nilai antara 0-20</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Keterangan:</strong><br>
                        - Core Factor: Aspek kompetensi yang paling utama/penting<br>
                        - Secondary Factor: Aspek pendukung kompetensi<br>
                        - Nilai Target Ideal menunjukkan standar yang diharapkan
                    </div>
                </div>
                <div class="card-footer">
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
    document.getElementById('formPenilaian').addEventListener('submit', function(e) {
        let allFilled = true;
        const radios = document.querySelectorAll('input[type="radio"]');
        const radioGroups = {};
        
        radios.forEach(radio => {
            radioGroups[radio.name] = radioGroups[radio.name] || [];
            radioGroups[radio.name].push(radio);
        });
        
        for (let group in radioGroups) {
            if (!radioGroups[group].some(radio => radio.checked)) {
                allFilled = false;
                break;
            }
        }
        
        if (!allFilled) {
            e.preventDefault();
            alert('Mohon lengkapi semua penilaian sebelum menyimpan!');
        }
    });
</script>
@endsection