@extends('layouts.app')

@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person me-2"></i>Detail Karyawan
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">NIK</th>
                        <td>{{ $karyawan->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $karyawan->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>{{ $karyawan->jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Unit Kerja</th>
                        <td>{{ $karyawan->unit_kerja ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('d M Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($karyawan->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @if($karyawan->foto)
                    <tr>
                        <th>Foto</th>
                        <td>
                            <img src="{{ asset('uploads/karyawan/' . $karyawan->foto) }}" 
                                 alt="{{ $karyawan->nama }}" width="150">
                        </td>
                    </tr>
                    @endif
                </table>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <div>
                        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection