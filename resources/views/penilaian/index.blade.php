@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page-title', 'Input Penilaian Karyawan')
@section('page-subtitle', 'Input nilai penilaian karyawan berdasarkan kriteria')

@section('content')
    @if(!$periodeAktif)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada periode penilaian aktif.
        </div>
    @else
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-1">Periode Aktif</h6>
                        <h5 class="mb-0 text-primary">{{ $periodeAktif->nama }} ({{ $periodeAktif->tahun }})</h5>
                        <small class="text-muted">
                            {{ $periodeAktif->tanggal_mulai->format('d M Y') }} -
                            {{ $periodeAktif->tanggal_selesai->format('d M Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-clipboard-data me-2"></i>Daftar Karyawan untuk Dinilai
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead class="table-light">
                            <tr>
                                <th width="60">No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th width="150">Progress</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawanList as $index => $k)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $k->nik }}</strong></td>
                                    <td>{{ $k->nama }}</td>
                                    <td>{{ $k->jabatan ?? '-' }}</td>
                                    <td>{{ $k->unit_kerja ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                <div class="progress-bar 
                                                                @if($k->is_complete) bg-success 
                                                                @elseif($k->progress > 50) bg-primary 
                                                                @else bg-warning 
                                                                @endif" role="progressbar" style="width: {{ $k->progress }}%"
                                                    aria-valuenow="{{ $k->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ $k->progress }}%
                                                </div>
                                            </div>
                                            @if($k->is_complete)
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($k->is_complete)
                                            <a href="{{ route('penilaian.create') }}?karyawan_id={{ $k->id }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                        @else
                                            <a href="{{ route('penilaian.create') }}?karyawan_id={{ $k->id }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                @if($k->progress > 0) Lanjutkan @else Mulai @endif
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection