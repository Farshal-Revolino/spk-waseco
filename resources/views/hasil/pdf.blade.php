<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Penilaian - {{ $periode->nama }}</title>

    <style>
        @page {
            margin: 18px 22px 24px 22px;
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

        /* ================= WATERMARK PERUSAHAAN ================= */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 430px;
            opacity: 0.055;
            z-index: -1;
        }

        /* ================= HEADER / KOP ================= */
        .kop {
            width: 100%;
            border-bottom: 3px solid #1a56a0;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 58px;
        }

        .kop-title {
            text-align: center;
            vertical-align: middle;
        }

        .kop-title h1 {
            font-size: 19px;
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
            font-size: 10px;
            color: #6b7280;
        }

        .kop-space {
            width: 80px;
        }

        /* ================= REPORT TITLE ================= */
        .report-title {
            text-align: center;
            margin-bottom: 12px;
        }

        .report-title h3 {
            font-size: 14px;
            color: #1a56a0;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .report-title p {
            font-size: 10px;
            color: #6b7280;
        }

        /* ================= INFO BOX ================= */
        .info-box {
            border: 1px solid #dbeafe;
            border-left: 5px solid #1a56a0;
            background: #f8fbff;
            padding: 9px 10px;
            margin-bottom: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 10px;
            vertical-align: top;
        }

        .info-label {
            width: 105px;
            font-weight: bold;
            color: #1a56a0;
        }

        .info-separator {
            width: 10px;
            text-align: center;
        }

        /* ================= STATISTICS ================= */
        .stats {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .stats td {
            width: 20%;
            padding: 7px;
            text-align: center;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .stat-value {
            font-size: 17px;
            font-weight: bold;
            color: #1a56a0;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 8.5px;
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

        /* ================= TABLE ================= */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .data-table th {
            background: #1a56a0;
            color: #ffffff;
            padding: 6px 5px;
            font-size: 8.5px;
            border: 1px solid #0d3b7a;
            text-align: center;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 5px 5px;
            border: 1px solid #d1d5db;
            font-size: 8.5px;
            text-align: center;
            vertical-align: middle;
        }

        .data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .data-table tr.top-rank {
            background: #fff8db;
        }

        .text-left {
            text-align: left !important;
        }

        .font-bold {
            font-weight: bold;
        }

        .nilai-total {
            color: #1a56a0;
            font-weight: bold;
        }

        /* ================= BADGE ================= */
        .ranking-badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .ranking-1 {
            background: #fbbf24;
            color: #111827;
        }

        .ranking-2 {
            background: #94a3b8;
            color: #ffffff;
        }

        .ranking-3 {
            background: #f87171;
            color: #ffffff;
        }

        .ranking-other {
            background: #e5e7eb;
            color: #374151;
        }

        .badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            color: #ffffff;
        }

        .badge-a {
            background: #10b981;
        }

        .badge-b {
            background: #3b82f6;
        }

        .badge-c {
            background: #f59e0b;
        }

        .badge-d {
            background: #ef4444;
        }

        /* ================= NOTE ================= */
        .note-box {
            margin-top: 10px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            font-size: 9px;
            color: #4b5563;
        }

        .note-box strong {
            color: #1a56a0;
        }

        /* ================= SIGNATURE ================= */
        .signature-section {
            width: 100%;
            margin-top: 28px;
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
            width: 220px;
            text-align: center;
            float: right;
        }

        .signature-space {
            height: 55px;
        }

        .signature-name {
            font-weight: bold;
            border-bottom: 1px solid #111827;
            display: inline-block;
            min-width: 160px;
            padding-bottom: 2px;
        }

        /* ================= FOOTER ================= */
        .footer {
            position: fixed;
            bottom: -12px;
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

    {{-- WATERMARK PERUSAHAAN --}}
    <img src="{{ public_path('img/waseco.png') }}" class="watermark">

    {{-- KOP SURAT --}}
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('img/waseco1.png') }}" alt="Logo">
                </td>

                <td class="kop-title">
                    <h1>PT. WASECO TIRTA</h1>
                    <h2>LAPORAN HASIL PENILAIAN KARYAWAN</h2>
                    <p>Sistem Pendukung Keputusan Penentuan Karyawan Terbaik - Metode Profile Matching</p>
                </td>

                <td class="kop-space"></td>
            </tr>
        </table>
    </div>

    {{-- JUDUL LAPORAN --}}
    <div class="report-title">
        <h3>Hasil Ranking Penilaian Karyawan</h3>
        <p>Daftar hasil perhitungan berdasarkan nilai akhir dan klasifikasi penilaian</p>
    </div>

    {{-- INFORMASI LAPORAN --}}
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="info-label">Periode</td>
                <td class="info-separator">:</td>
                <td>{{ $periode->nama }} ({{ $periode->tahun }})</td>

                <td class="info-label">Tanggal Cetak</td>
                <td class="info-separator">:</td>
                <td>{{ now()->format('d F Y') }}</td>
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

    {{-- STATISTIK --}}
    <table class="stats">
        <tr>
            <td>
                <div class="stat-value">{{ $stats['total'] ?? $hasilList->count() }}</div>
                <div class="stat-label">Total Karyawan</div>
            </td>
            <td>
                <div class="stat-value stat-a">
                    {{ $stats['klasifikasi_a'] ?? $hasilList->where('klasifikasi', 'A')->count() }}</div>
                <div class="stat-label">A - Baik Sekali</div>
            </td>
            <td>
                <div class="stat-value stat-b">
                    {{ $stats['klasifikasi_b'] ?? $hasilList->where('klasifikasi', 'B')->count() }}</div>
                <div class="stat-label">B - Baik</div>
            </td>
            <td>
                <div class="stat-value stat-c">
                    {{ $stats['klasifikasi_c'] ?? $hasilList->where('klasifikasi', 'C')->count() }}</div>
                <div class="stat-label">C - Cukup</div>
            </td>
            <td>
                <div class="stat-value stat-d">
                    {{ $stats['klasifikasi_d'] ?? $hasilList->where('klasifikasi', 'D')->count() }}</div>
                <div class="stat-label">D - Kurang</div>
            </td>
        </tr>
    </table>

    {{-- TABEL HASIL --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="6%">Rank</th>
                <th width="14%">NIK</th>
                <th width="23%">Nama Karyawan</th>
                <th width="18%">Jabatan</th>
                <th width="9%">Teknis</th>
                <th width="10%">Non Teknis</th>
                <th width="10%">Kepribadian</th>
                <th width="10%">Kepemimpinan</th>
                <th width="10%">Nilai Total</th>
                <th width="7%">Kelas</th>
            </tr>
        </thead>

        <tbody>
            @foreach($hasilList as $hasil)
                <tr class="{{ $hasil->ranking <= 3 ? 'top-rank' : '' }}">
                    <td>
                        <span class="ranking-badge
                                @if($hasil->ranking == 1) ranking-1
                                @elseif($hasil->ranking == 2) ranking-2
                                @elseif($hasil->ranking == 3) ranking-3
                                @else ranking-other
                                @endif">
                            #{{ $hasil->ranking }}
                        </span>
                    </td>

                    <td>{{ $hasil->karyawan->nik }}</td>

                    <td class="text-left font-bold">
                        {{ $hasil->karyawan->nama }}
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

    {{-- KETERANGAN --}}
    <div class="note-box">
        <strong>Keterangan:</strong>
        Nilai akhir diperoleh berdasarkan perhitungan metode Profile Matching yang meliputi proses perhitungan GAP,
        pembobotan GAP, Core Factor, Secondary Factor, nilai per aspek, dan konversi skor akhir ke skala maksimal 320.
        Klasifikasi nilai terdiri dari A (241-320), B (161-240), C (81-160), dan D (0-80).
    </div>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td></td>
                <td>
                    <div class="signature-box">
                        <p>Jakarta, {{ now()->format('d F Y') }}</p>
                        <p>Direktur Utama</p>

                        <div class="signature-space"></div>

                        <p class="signature-name">&nbsp;</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Penilaian Karyawan PT Waseco Tirta.
    </div>

</body>

</html>