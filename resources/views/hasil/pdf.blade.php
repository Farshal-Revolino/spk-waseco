<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Penilaian - {{ $periode->nama }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            position: relative;
        }

        /* ================= WATERMARK ================= */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            opacity: 0.06;
            /* makin kecil makin samar */
            z-index: -1;
        }

        /* ================= HEADER ================= */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1a56a0;
        }

        .header h1 {
            font-size: 18px;
            color: #1a56a0;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            color: #666;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 10px;
            color: #999;
        }

        .header-kop {
            text-align: center;
        }

        .logo {
            width: 50px;
            margin-bottom: 5px;
        }

        /* ================= INFO ================= */
        .info-box {
            background: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #1a56a0;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 3px 0;
            font-size: 10px;
        }

        .info-box strong {
            color: #1a56a0;
        }

        /* ================= STATS ================= */
        .stats {
            margin: 15px 0;
            display: table;
            width: 100%;
        }

        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: #f8f9fa;
            border-right: 2px solid white;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #1a56a0;
        }

        .stat-label {
            font-size: 9px;
            color: #666;
        }

        /* ================= TABLE ================= */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th {
            background: #1a56a0;
            color: white;
            padding: 6px;
            font-size: 9px;
            border: 1px solid #0d3b7a;
        }

        table.data-table td {
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 9px;
            text-align: center;
        }

        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        /* ================= BADGE ================= */
        .ranking-badge {
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
        }

        .ranking-1 {
            background: #fbbf24;
        }

        .ranking-2 {
            background: #94a3b8;
            color: white;
        }

        .ranking-3 {
            background: #f87171;
            color: white;
        }

        .ranking-other {
            background: #e5e7eb;
        }

        .badge {
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            color: white;
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
    </style>
</head>

<body>

    <!-- WATERMARK -->
    <img src="{{ public_path('img/waseco.png') }}" class="watermark">

    <!-- HEADER -->
    <div class="header">
        <div class="header-kop">
            <img src="{{ public_path('img/waseco1.png') }}" class="logo">
            <h1>PT. WASECO TIRTA</h1>
        </div>
        <h2>LAPORAN HASIL PENILAIAN KARYAWAN</h2>
        <p>Sistem Pendukung Keputusan - Metode Profile Matching</p>
    </div>

    <!-- INFO -->
    <div class="info-box">
        <table>
            <tr>
                <td width="150"><strong>Periode</strong></td>
                <td>: {{ $periode->nama }} ({{ $periode->tahun }})</td>
                <td width="150"><strong>Tanggal Cetak</strong></td>
                <td>: {{ now()->format('d F Y') }}</td>
            </tr>
        </table>
    </div>


    <!-- TABLE -->
    <table class="data-table">
        <thead>
            <tr>
                <th>RANK</th>
                <th>NIK</th>
                <th>NAMA</th>
                <th>JABATAN</th>
                <th>NILAI</th>
                <th>KELAS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilList as $hasil)
                <tr>
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
                    <td class="text-left">{{ $hasil->karyawan->nama }}</td>
                    <td class="text-left">{{ $hasil->karyawan->jabatan ?? '-' }}</td>
                    <td class="font-bold">{{ number_format($hasil->nilai_total, 2) }}</td>
                    <td>
                        <span class="badge badge-{{ strtolower($hasil->klasifikasi) }}">
                            {{ $hasil->klasifikasi }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>