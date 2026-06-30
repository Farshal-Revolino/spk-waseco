@extends('layouts.app')

@section('title', 'Validasi Laporan')
@section('page-title', 'Validasi Laporan Penilaian')
@section('page-subtitle', 'Persetujuan dan pemberian catatan hasil penilaian karyawan')

@section('styles')
    <style>
        .validation-card {
            border: none;
            border-radius: 22px;
            box-shadow: 0 10px 26px rgba(0, 0, 0, .06);
            overflow: hidden;
            background: #fff;
        }

        .validation-header {
            padding: 20px 24px;
            border-bottom: 1px solid #edf0f3;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            border-radius: 14px;
            padding: 12px 20px;
            font-weight: 750;
            transition: 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .status-badge-large {
            border-radius: 999px;
            padding: 10px 20px;
            font-weight: 800;
            font-size: 14px;
        }

        .rank-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            border-radius: 16px;
            border: 1px solid #f1f3f5;
            margin-bottom: 10px;
            background: #f8f9fb;
        }

        .rank-badge-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
        }

        .rank-1 { background-color: #ffc107; color: #000; }
        .rank-2 { background-color: #6c757d; color: #fff; }
        .rank-3 { background-color: #dc3545; color: #fff; }
    </style>
@endsection

@section('content')

    @php
        $status = $statusValidasi ?? 'menunggu';

        $badgeValidasi = [
            'menunggu' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
        ][$status] ?? 'secondary';

        $labelValidasi = [
            'menunggu' => 'Menunggu Validasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ][$status] ?? 'Tidak Diketahui';

        $hasilCollection = collect($hasilList ?? []);
        $topThree = $hasilCollection->take(3);
    @endphp

    @if($periode)
        <div class="row g-4">
            
            {{-- FORM VALIDASI (KIRI) --}}
            <div class="col-lg-7">
                <div class="card validation-card h-100">
                    <div class="validation-header">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-shield-check text-primary me-2"></i>
                                Form Keputusan Direktur
                            </h5>
                            <small class="text-muted">
                                Berikan persetujuan atau catatan penolakan untuk laporan periode aktif
                            </small>
                        </div>
                        
                        <span class="badge bg-{{ $badgeValidasi }} status-badge-large">
                            {{ $labelValidasi }}
                        </span>
                    </div>

                    <div class="card-body p-4">
                        @if($validasi)
                            <div class="alert alert-{{ $badgeValidasi }} d-flex align-items-start gap-3">
                                <div class="fs-4"><i class="bi bi-info-circle-fill"></i></div>
                                <div>
                                    <div class="fw-bold mb-1">Laporan Telah Diproses</div>
                                    <div class="small">
                                        Status terakhir: <strong>{{ $labelValidasi }}</strong><br>
                                        Validator: {{ $validasi->user->name ?? '-' }}<br>
                                        Tanggal: {{ $validasi->tanggal_validasi ? \Carbon\Carbon::parse($validasi->tanggal_validasi)->format('d M Y H:i') : '-' }}
                                    </div>
                                    
                                    @if($validasi->catatan_validasi)
                                        <div class="mt-2 p-2 bg-white bg-opacity-25 rounded small">
                                            <strong>Catatan:</strong> "{{ $validasi->catatan_validasi }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center gap-3">
                                <div class="fs-4"><i class="bi bi-hourglass-split"></i></div>
                                <div>
                                    Laporan hasil penilaian untuk periode ini belum divalidasi. Silakan periksa ringkasan di samping dan berikan keputusan Anda.
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('direktur.validasi-hasil') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="periode_id" value="{{ $periode->id }}">

                            <div class="mb-4">
                                <label for="catatan_validasi" class="form-label fw-bold">
                                    Catatan Validasi / Catatan Revisi
                                </label>
                                <textarea id="catatan_validasi" name="catatan_validasi" class="form-control" rows="5"
                                    placeholder="Wajib diisi jika Anda menolak laporan sebagai arahan revisi bagi HRD. Opsional jika disetujui.">{{ old('catatan_validasi', $validasi->catatan_validasi ?? '') }}</textarea>
                            </div>

                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <button type="submit" name="status_validasi" value="disetujui"
                                        class="btn btn-success btn-action w-100 py-3"
                                        onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI laporan hasil penilaian ini?')">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        Setujui Laporan
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" name="status_validasi" value="ditolak" 
                                        class="btn btn-danger btn-action w-100 py-3"
                                        onclick="return confirm('Apakah Anda yakin ingin MENOLAK laporan hasil penilaian ini?')">
                                        <i class="bi bi-x-circle-fill me-2"></i>
                                        Tolak Laporan
                                    </button>
                                </div>
                                @if($hasilCollection->isNotEmpty())
                                    <div class="col-12 mt-3">
                                        <a href="{{ route('hasil.export-pdf') }}?periode_id={{ $periode->id }}"
                                            class="btn btn-outline-secondary w-100 py-3" style="border-radius: 14px; font-weight: 750;" target="_blank">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                                            Pratinjau PDF Laporan
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RINGKASAN DATA & TOP KARYAWAN (KANAN) --}}
            <div class="col-lg-5">
                <div class="card validation-card h-100">
                    <div class="validation-header">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-trophy-fill text-warning me-2"></i>
                                Ringkasan Hasil Penilaian
                            </h5>
                            <small class="text-muted">
                                Periode: {{ $periode->nama }} ({{ $periode->tahun }})
                            </small>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if($hasilCollection->isNotEmpty())
                            <h6 class="fw-bold mb-3">Top 3 Karyawan Terbaik:</h6>
                            <div class="mb-4">
                                @foreach($topThree as $index => $hasil)
                                    @php
                                        $rank = $loop->iteration;
                                    @endphp
                                    <div class="rank-item">
                                        <div class="rank-badge-circle rank-{{ $rank }}">
                                            {{ $rank }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-dark">{{ $hasil->karyawan->nama }}</div>
                                            <small class="text-muted">{{ $hasil->karyawan->jabatan ?? 'Karyawan' }} | NIK: {{ $hasil->karyawan->nik }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-primary">{{ number_format($hasil->nilai_total, 2) }}</div>
                                            <span class="badge bg-{{ $hasil->klasifikasi == 'A' ? 'success' : ($hasil->klasifikasi == 'B' ? 'primary' : 'warning') }} small">Kelas {{ $hasil->klasifikasi }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <div class="mt-3">
                                <h6 class="fw-bold mb-3">Keterangan Tambahan:</h6>
                                <p class="text-muted small">
                                    Hasil di atas dihitung secara sistematis menggunakan metode **Profile Matching** berdasarkan kriteria yang telah ditentukan. Anda dapat meninjau lembar laporan lengkap dalam format PDF melalui tombol pratinjau sebelum mengambil keputusan validasi resmi.
                                </p>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard-x fs-1 mb-3 d-block"></i>
                                <h6>Hasil perhitungan belum dikalkulasi oleh HRD.</h6>
                                <p class="small mb-0">Menu validasi akan aktif setelah HRD memproses data penilaian pada sistem.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="card validation-card">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-calendar-x fs-1 mb-3 d-block"></i>
                <h5 class="fw-bold text-dark">Tidak Ada Periode Penilaian Aktif</h5>
                <p class="small mb-0">Pastikan HRD atau Administrator telah mengaktifkan salah satu periode penilaian di dalam sistem.</p>
            </div>
        </div>
    @endif

@endsection
