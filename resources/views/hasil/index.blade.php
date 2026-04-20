@extends('layouts.app')

@section('title', 'Hasil Perhitungan')
@section('page-title', 'Hasil Perhitungan Profile Matching')
@section('page-subtitle', 'Ranking dan hasil penilaian karyawan terbaik')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label for="periode_select" class="form-label">Pilih Periode:</label>
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
                <div class="col-md-6 text-md-end">
                    @if($periode)
                        <form action="{{ route('hasil.calculate') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Proses perhitungan akan menghapus hasil sebelumnya. Lanjutkan?')">
                                <i class="bi bi-calculator me-1"></i>Proses Perhitungan
                            </button>
                        </form>
                        
                        @if(count($hasilList) > 0)
                        <a href="{{ route('hasil.export-pdf') }}?periode_id={{ $periode->id }}" 
                           class="btn btn-danger ms-2" 
                           target="_blank">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i>Export PDF
                        </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($periode && count($hasilList) > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-trophy me-2"></i>Ranking Karyawan Terbaik
                <span class="badge bg-white text-primary ms-2">{{ $periode->nama }} ({{ $periode->tahun }})</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead class="table-light">
                            <tr>
                                <th width="80" class="text-center">Ranking</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Jabatan</th>
                                <th class="text-center">N. Teknis</th>
                                <th class="text-center">N. Non Teknis</th>
                                <th class="text-center">N. Kepribadian</th>
                                <th class="text-center">N. Kepemimpinan</th>
                                <th class="text-center">Nilai Total</th>
                                <th class="text-center">Klasifikasi</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasilList as $hasil)
                                <tr class="{{ $hasil->ranking <= 3 ? 'table-warning' : '' }}">
                                    <td class="text-center">
                                        <span class="badge 
                                            @if($hasil->ranking == 1) bg-warning text-dark
                                            @elseif($hasil->ranking == 2) bg-secondary
                                            @elseif($hasil->ranking == 3) bg-danger
                                            @else bg-light text-dark
                                            @endif
                                            fs-6">
                                            @if($hasil->ranking <= 3)
                                                <i class="bi bi-trophy-fill"></i>
                                            @endif
                                            #{{ $hasil->ranking }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $hasil->karyawan->nik }}</strong></td>
                                    <td>
                                        <strong>{{ $hasil->karyawan->nama }}</strong>
                                        @if($hasil->ranking <= 3)
                                            <i class="bi bi-star-fill text-warning ms-1"></i>
                                        @endif
                                    </td>
                                    <td>{{ $hasil->karyawan->jabatan ?? '-' }}</td>
                                    <td class="text-center">{{ number_format($hasil->nilai_teknis, 2) }}</td>
                                    <td class="text-center">{{ number_format($hasil->nilai_non_teknis, 2) }}</td>
                                    <td class="text-center">{{ number_format($hasil->nilai_kepribadian, 2) }}</td>
                                    <td class="text-center">{{ number_format($hasil->nilai_kepemimpinan, 2) }}</td>
                                    <td class="text-center">
                                        <strong class="text-primary">{{ number_format($hasil->nilai_total, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $hasil->klasifikasi_badge }}">
                                            {{ $hasil->klasifikasi }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hasil.show', $hasil->karyawan_id) }}?periode_id={{ $periode->id }}"
                                            class="btn btn-sm btn-info" title="Lihat Detail">
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

        <!-- Statistik -->
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-success mb-0">{{ collect($hasilList)->where('klasifikasi', 'A')->count() }}</h3>
                        <p class="text-muted mb-0">Baik Sekali (A)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-primary mb-0">{{ collect($hasilList)->where('klasifikasi', 'B')->count() }}</h3>
                        <p class="text-muted mb-0">Baik (B)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-warning mb-0">{{ collect($hasilList)->where('klasifikasi', 'C')->count() }}</h3>
                        <p class="text-muted mb-0">Cukup (C)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="text-danger mb-0">{{ collect($hasilList)->where('klasifikasi', 'D')->count() }}</h3>
                        <p class="text-muted mb-0">Kurang (D)</p>
                    </div>
                </div>
            </div>
        </div>

    @elseif($periode)
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-calculator" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="mt-3">Belum Ada Hasil Perhitungan</h4>
                <p class="text-muted">Silakan proses perhitungan terlebih dahulu untuk melihat hasil ranking.</p>
                <form action="{{ route('hasil.calculate') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-calculator me-1"></i>Mulai Perhitungan
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="mt-3">Pilih Periode Terlebih Dahulu</h4>
                <p class="text-muted">Pilih periode penilaian untuk melihat hasil perhitungan.</p>
            </div>
        </div>
    @endif
@endsection