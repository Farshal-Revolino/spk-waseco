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
        }

        .header {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1a56a0;
        }

        .header h1 {
            font-size: 18px;
            color: #1a56a0;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 10px;
            color: #999;
        }

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

        .stats {
            margin: 15px 0;
            display: table;
            width: 100%;
        }

        .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
            background: #f8f9fa;
            border-right: 2px solid white;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #1a56a0;
            display: block;
        }

        .stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            margin-top: 3px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table thead th {
            background: #1a56a0;
            color: white;
            padding: 8px 5px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            border: 1px solid #0d3b7a;
        }

        table.data-table tbody td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9px;
            text-align: center;
        }

        table.data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .ranking-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }

        .ranking-1 {
            background: #fbbf24;
            color: #78350f;
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
            color: #374151;
        }

        .badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-a {
            background: #10b981;
            color: white;
        }

        .badge-b {
            background: #3b82f6;
            color: white;
        }

        .badge-c {
            background: #f59e0b;
            color: white;
        }

        .badge-d {
            background: #ef4444;
            color: white;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .header-kop {
            display: flex;
            align-items: center;
            /* bikin sejajar vertikal */
            justify-content: center;
            /* tetap center */
            gap: 10px;
            /* jarak logo & teks */
        }

        .logo {
            width: 50px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-kop">
            <img src="{{ public_path('img/waseco1.png') }}" class="logo">
            <h1>PT. WASECO TIRTA</h1>
        </div>

        <h2>LAPORAN HASIL PENILAIAN KARYAWAN</h2>
        <p>Sistem Pendukung Keputusan - Metode Profile Matching</p>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td width="150"><strong>Periode Penilaian</strong></td>
                <td>: {{ $periode->nama }} ({{ $periode->tahun }})</td>
                <td width="150" class="text-right"><strong>Tanggal Cetak</strong></td>
                <td width="120">: {{ now()->format('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Durasi Periode</strong></td>
                <td>: {{ $periode->tanggal_mulai->format('d M Y') }} s/d
                    {{ $periode->tanggal_selesai->format('d M Y') }}
                </td>
                <td class="text-right"><strong>Total Karyawan</strong></td>
                <td>: {{ $stats['total'] }} Orang</td>
            </tr>
        </table>
    </div>

    <div class="stats">
        <div class="stat-item">
            <span class="stat-value">{{ $stats['klasifikasi_a'] }}</span>
            <span class="stat-label">Klasifikasi A<br>(Baik Sekali)</span>
        </div>
        <div class="stat-item">
            <span class="stat-value">{{ $stats['klasifikasi_b'] }}</span>
            <span class="stat-label">Klasifikasi B<br>(Baik)</span>
        </div>
        <div class="stat-item">
            <span class="stat-value">{{ $stats['klasifikasi_c'] }}</span>
            <span class="stat-label">Klasifikasi C<br>(Cukup)</span>
        </div>
        <div class="stat-item">
            <span class="stat-value">{{ $stats['klasifikasi_d'] }}</span>
            <span class="stat-label">Klasifikasi D<br>(Kurang)</span>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="40">RANK</th>
                <th width="70">NIK</th>
                <th width="150">NAMA KARYAWAN</th>
                <th width="120">JABATAN</th>
                <th width="60">N. TEKNIS</th>
                <th width="60">N. NON TKN</th>
                <th width="60">N. KEPRIB</th>
                <th width="60">N. KEPEM</th>
                <th width="70">NILAI TOTAL</th>
                <th width="50">KELAS</th>
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
                    <td class="font-bold">{{ $hasil->karyawan->nik }}</td>
                    <td class="text-left">{{ $hasil->karyawan->nama }}</td>
                    <td class="text-left">{{ $hasil->karyawan->jabatan ?? '-' }}</td>
                    <td>{{ number_format($hasil->nilai_teknis, 2) }}</td>
                    <td>{{ number_format($hasil->nilai_non_teknis, 2) }}</td>
                    <td>{{ number_format($hasil->nilai_kepribadian, 2) }}</td>
                    <td>{{ number_format($hasil->nilai_kepemimpinan, 2) }}</td>
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

    <div style="margin-top: 20px; font-size: 9px;">
        <strong>KETERANGAN:</strong><br>
        <table style="margin-top: 5px; width: 100%;">
            <tr>
                <td width="50%">
                    • N. Teknis: Nilai Aspek Teknis (Bobot 35%)<br>
                    • N. Non Tkn: Nilai Aspek Non Teknis (Bobot 25%)
                </td>
                <td width="50%">
                    • N. Keprib: Nilai Aspek Kepribadian (Bobot 25%)<br>
                    • N. Kepem: Nilai Aspek Kepemimpinan (Bobot 15%)
                </td>
            </tr>
        </table>
        <p style="margin-top: 8px;">
            <strong>Klasifikasi:</strong>
            A (241-320) = Baik Sekali | B (161-240) = Baik | C (81-160) = Cukup | D (0-80) = Kurang
        </p>
    </div>

    <div style="margin-top: 30px;">
        <table style="width: 100%;">
            <tr>
                <td width="50%"></td>
                <td width="50%" style="text-align: center;">
                    <p>Bandung, {{ now()->format('d F Y') }}</p>
                    <p style="margin-top: 5px;"><strong>DIREKTUR UTAMA</strong></p>
                    <p
                        style="margin-top: 60px; border-top: 1px solid #333; padding-top: 5px; display: inline-block; width: 200px;">
                        ( ............................. )
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>