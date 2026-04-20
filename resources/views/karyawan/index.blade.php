@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Manajemen Data Karyawan PT Waseco Tirta')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-people me-2"></i>Daftar Karyawan</span>
            <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Karyawan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Foto</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Unit Kerja</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawan as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($k->foto)
                                        <img src="{{ asset('uploads/karyawan/' . $k->foto) }}" alt="{{ $k->nama }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $k->nik }}</strong></td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->jabatan ?? '-' }}</td>
                                <td>{{ $k->unit_kerja ?? '-' }}</td>
                                <td>{{ $k->tanggal_masuk ? $k->tanggal_masuk->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($k->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirmDelete(this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus">
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
        </div>
    </div>
@endsection