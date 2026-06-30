<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Penilaian - {{ $periode->nama }}</title>

    <style>
        @page {
            margin: 18px 22px 25px 22px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1f2937;
            position: relative;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 430px;
            opacity: 0.045;
            z-index: -1;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #1a56a0;
            padding-bottom: 10px;
            margin-bottom: 13px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 85px;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 60px;
        }

        .kop-title {
            text-align: center;
            vertical-align: middle;
        }

        .kop-title h1 {
            font-size: 20px;
            color: #1a56a0;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }

        .kop-title h2 {
            font-size: 13px;
            color: #111827;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .kop-title p {
            font-size: 9.5px;
            color: #6b7280;
        }

        .kop-space {
            width: 85px;
        }

        .report-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .report-title h3 {
            font-size: 14px;
            color: #1a56a0;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .report-title p {
            font-size: 9.5px;
            color: #6b7280;
        }

        /* PERBAIKAN: Info Box & Note Box Lebih Bersih */
        .info-box,
        .note-box,
        .approval-box {
            border: 1px solid #d1d5db;
            border-left: 4px solid #1a56a0;
            background: #ffffff;
            padding: 8px 10px;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 9.5px;
            vertical-align: top;
        }

        .info-label {
            width: 115px;
            font-weight: bold;
            color: #1a56a0;
        }

        .info-separator {
            width: 10px;
            text-align: center;
        }

        .note-box,
        .approval-box {
            font-size: 9px;
            color: #374151;
        }

        .note-box strong,
        .approval-box strong {
            color: #1a56a0;
        }

        /* Validasi Box */
        .validasi-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .validasi-box td {
            border: 1px solid #d1d5db;
            padding: 7px 8px;
            vertical-align: middle;
            background: #ffffff;
        }

        .validasi-title {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .validasi-value {
            font-size: 11px;
            font-weight: bold;
            color: #111827;
        }

        .status-label {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-menunggu {
            background: #f59e0b;
        }

        .status-disetujui {
            background: #10b981;
        }

        .status-ditolak {
            background: #ef4444;
        }

        /* PERBAIKAN: Top 3 Section Tampil Elegan */
        .top-section-title {
            font-size: 11px;
            font-weight: bold;
            color: #1a56a0;
            margin: 8px 0 5px 0;
            text-transform: uppercase;
        }

        .top-three {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .top-three td {
            width: 33.33%;
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: top;
            background: #ffffff;
        }

        .top-card-1 {
            border-top: 3px solid #1a56a0 !important;
        }

        .top-card-2 {
            border-top: 3px solid #64748b !important;
        }

        .top-card-3 {
            border-top: 3px solid #94a3b8 !important;
        }

        .top-rank {
            font-size: 12px;
            font-weight: bold;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .top-name {
            font-size: 10px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 2px;
        }

        .top-job {
            font-size: 8.5px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .top-score {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
        }

        /* Stats Section */
        .stats {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .stats td {
            width: 20%;
            padding: 7px;
            text-align: center;
            border: 1px solid #d1d5db;
            background: #ffffff;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
        }

        .stat-a {
            color: #059669;
        }

        .stat-b {
            color: #2563eb;
        }

        .stat-c {
            color: #d97706;
        }

        .stat-d {
            color: #dc2626;
        }

        /* PERBAIKAN: Data Table Lebih Bersih (Zebra Putih-Abu) */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .data-table th {
            background: #1a56a0;
            color: #ffffff;
            padding: 6px 4px;
            font-size: 8px;
            border: 1px solid #1a56a0;
            text-align: center;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 5px 4px;
            border: 1px solid #d1d5db;
            font-size: 8px;
            text-align: center;
            vertical-align: middle;
        }

        .data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-left {
            text-align: left !important;
        }

        .font-bold {
            font-weight: bold;
        }

        .nilai-total {
            color: #111827;
            font-weight: bold;
        }

        /* PERBAIKAN: Badge Hanya Berupa Teks Tebal Berwarna */
        .ranking-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: bold;
            color: #111827;
        }

        .badge {
            display: inline-block;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-a {
            color: #059669;
        }

        .badge-b {
            color: #2563eb;
        }

        .badge-c {
            color: #d97706;
        }

        .badge-d {
            color: #dc2626;
        }

        /* Signatures */
        .signature-section {
            width: 100%;
            margin-top: 23px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
            font-size: 10px;
        }

        .signature-box {
            width: 230px;
            text-align: center;
            float: right;
        }

        .signature-space {
            height: 48px;
        }

        .signature-name {
            font-weight: bold;
            border-bottom: 1px solid #111827;
            display: inline-block;
            min-width: 160px;
            padding-bottom: 2px;
        }

        .footer {
            position: fixed;
            bottom: -13px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    @php
        $validasi = $validasi ?? null;
        $statusValidasi = $statusValidasi ?? 'menunggu';

        $labelValidasi = [
            'menunggu' => 'Menunggu Validasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ][$statusValidasi] ?? 'Tidak Diketahui';

        $statusClass = [
            'menunggu' => 'status-menunggu',
            'disetujui' => 'status-disetujui',
            'ditolak' => 'status-ditolak',
        ][$statusValidasi] ?? 'status-menunggu';

        $topThree = collect($hasilList)->sortBy('ranking')->take(3)->values();

        $tanggalValidasi = $validasi && $validasi->tanggal_validasi
            ? \Carbon\Carbon::parse($validasi->tanggal_validasi)->format('d-m-Y H:i')
            : '-';

        $namaValidator = ($validasi && $validasi->user) ? $validasi->user->name : '-';
        $catatanValidasi = $validasi ? $validasi->catatan_validasi : '-';
    @endphp

    @if(file_exists(public_path('img/waseco.png')))
        <img src="{{ public_path('img/waseco.png') }}" class="watermark">
    @endif

    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    @if(file_exists(public_path('img/waseco1.png')))
                        <img src="{{ public_path('img/waseco1.png') }}" alt="Logo">
                    @endif
                </td>

                <td class="kop-title">
                    <h1>PT. WASECO TIRTA</h1>
                    <h2>LAPORAN HASIL PENILAIAN KARYAWAN</h2>
                    <p>Sistem Pendukung Keputusan Penentuan Karyawan Terbaik Menggunakan Metode Profile Matching</p>
                </td>

                <td class="kop-space"></td>
            </tr>
        </table>
    </div>

    <div class="report-title">
        <h3>Hasil Akhir Ranking Karyawan Terbaik</h3>
        <p>Daftar hasil perhitungan berdasarkan nilai akhir, klasifikasi, dan status validasi laporan</p>
    </div>

    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="info-label">Periode</td>
                <td class="info-separator">:</td>
                <td>{{ $periode->nama }} ({{ $periode->tahun }})</td>

                <td class="info-label">Tanggal Cetak</td>
                <td class="info-separator">:</td>
                <td>{{ now()->format('d-m-Y') }}</td>
            </tr>

            <tr>
                <td class="info-label">Metode</td>
                <td class="info-separator">:</td>
                <td>Profile Matching</td>

                <td class="info-label">Jumlah Data</td>
                <td class="info-separator">:</td>
                <td>{{ $hasilList->count() }} Karyawan</td>
            </tr>
        </table>
    </div>

    <table class="validasi-box">
        <tr>
            <td width="25%">
                <div class="validasi-title">Status Validasi</div>
                <div class="validasi-value">
                    <span class="status-label {{ $statusClass }}">
                        {{ $labelValidasi }}
                    </span>
                </div>
            </td>

            <td width="25%">
                <div class="validasi-title">Divalidasi Oleh</div>
                <div class="validasi-value">{{ $namaValidator }}</div>
            </td>

            <td width="25%">
                <div class="validasi-title">Tanggal Validasi</div>
                <div class="validasi-value">{{ $tanggalValidasi }}</div>
            </td>

            <td width="25%">
                <div class="validasi-title">Catatan</div>
                <div class="validasi-value">{{ $catatanValidasi }}</div>
            </td>
        </tr>
    </table>

    @if($topThree->count() > 0)
        <div class="top-section-title">Top 3 Karyawan Terbaik</div>

        <table class="top-three">
            <tr>
                @foreach($topThree as $hasil)
                    <td class="top-card-{{ $hasil->ranking }}">
                        <div class="top-rank">Ranking {{ $hasil->ranking }}</div>

                        <div class="top-name">
                            {{ $hasil->karyawan->nama ?? '-' }}
                        </div>

                        <div class="top-job">
                            {{ $hasil->karyawan->jabatan ?? '-' }}
                        </div>

                        <div class="top-score">
                            {{ number_format($hasil->nilai_total, 2) }}
                        </div>

                        <div>
                            Kelas {{ $hasil->klasifikasi }}
                        </div>
                    </td>
                @endforeach
            </tr>
        </table>
    @endif

    <table class="stats">
        <tr>
            <td>
                <div class="stat-value">{{ $stats['total'] ?? $hasilList->count() }}</div>
                <div class="stat-label">Total Karyawan</div>
            </td>

            <td>
                <div class="stat-value stat-a">
                    {{ $stats['klasifikasi_a'] ?? $hasilList->where('klasifikasi', 'A')->count() }}
                </div>
                <div class="stat-label">A - Baik Sekali</div>
            </td>

            <td>
                <div class="stat-value stat-b">
                    {{ $stats['klasifikasi_b'] ?? $hasilList->where('klasifikasi', 'B')->count() }}
                </div>
                <div class="stat-label">B - Baik</div>
            </td>

            <td>
                <div class="stat-value stat-c">
                    {{ $stats['klasifikasi_c'] ?? $hasilList->where('klasifikasi', 'C')->count() }}
                </div>
                <div class="stat-label">C - Cukup</div>
            </td>

            <td>
                <div class="stat-value stat-d">
                    {{ $stats['klasifikasi_d'] ?? $hasilList->where('klasifikasi', 'D')->count() }}
                </div>
                <div class="stat-label">D - Kurang</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="6%">Rank</th>
                <th width="13%">NIK</th>
                <th width="20%">Nama Karyawan</th>
                <th width="15%">Jabatan</th>
                <th width="8%">Teknis</th>
                <th width="9%">Non Teknis</th>
                <th width="9%">Kepribadian</th>
                <th width="10%">Kepemimpinan</th>
                <th width="9%">Total</th>
                <th width="6%">Kelas</th>
            </tr>
        </thead>

        <tbody>
            @foreach($hasilList as $hasil)
                <tr>
                    <td>
                        <span class="ranking-badge">
                            {{ $hasil->ranking }}
                        </span>
                    </td>

                    <td>{{ $hasil->karyawan->nik ?? '-' }}</td>

                    <td class="text-left font-bold">
                        {{ $hasil->karyawan->nama ?? '-' }}
                    </td>

                    <td class="text-left">
                        {{ $hasil->karyawan->jabatan ?? '-' }}
                    </td>

                    <td>{{ number_format($hasil->nilai_teknis, 2) }}</td>
                    <td>{{ number_format($hasil->nilai_non_teknis, 2) }}</td>
                    <td>{{ number_format($hasil->nilai_kepribadian, 2) }}</td>
                    <td>{{ number_format($hasil->nilai_kepemimpinan, 2) }}</td>

                    <td class="nilai-total">
                        {{ number_format($hasil->nilai_total, 2) }}
                    </td>

                    <td>
                        <span class="badge badge-{{ strtolower($hasil->klasifikasi) }}">
                            {{ $hasil->klasifikasi }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="note-box">
        <strong>Keterangan:</strong>
        Nilai akhir diperoleh berdasarkan perhitungan metode Profile Matching yang meliputi proses perhitungan GAP,
        pembobotan GAP, Core Factor, Secondary Factor, nilai per aspek, dan konversi skor akhir ke skala maksimal 320.
        Klasifikasi nilai terdiri dari A (241-320), B (161-240), C (81-160), dan D (0-80).
    </div>

    <div class="approval-box">
        <strong>Informasi Validasi:</strong>
        Laporan hasil penilaian ini divalidasi oleh Direktur Utama berdasarkan hasil ranking karyawan pada periode
        penilaian yang dipilih. Apabila status laporan adalah disetujui, maka laporan dapat digunakan sebagai hasil
        akhir penilaian karyawan terbaik. Apabila status laporan ditolak, maka HRD/Admin perlu melakukan pemeriksaan
        kembali terhadap data penilaian dan memproses ulang perhitungan.
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td></td>
                <td>
                    <div class="signature-box">
                        <p>Jakarta, {{ now()->format('d-m-Y') }}</p>
                        <p>Direktur Utama</p>

                        <div class="signature-space"></div>

                        <p class="signature-name">
                            {{ $statusValidasi === 'disetujui' ? ($namaValidator !== '-' ? $namaValidator : '') : '' }}
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Penilaian Karyawan PT Waseco Tirta.
    </div>

</body>

</html>