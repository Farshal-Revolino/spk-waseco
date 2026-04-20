<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User Admin
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@waseco.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HRD Manager',
                'email' => 'hrd@waseco.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Bobot GAP
        DB::table('bobot_gap')->insert([
            ['selisih' => 0, 'bobot' => 5.0, 'keterangan' => 'Kompetensi sesuai dengan yang dibutuhkan'],
            ['selisih' => 1, 'bobot' => 4.5, 'keterangan' => 'Kompetensi individu kelebihan 1 tingkat'],
            ['selisih' => -1, 'bobot' => 4.0, 'keterangan' => 'Kompetensi individu kekurangan 1 tingkat'],
            ['selisih' => 2, 'bobot' => 3.5, 'keterangan' => 'Kompetensi individu kelebihan 2 tingkat'],
            ['selisih' => -2, 'bobot' => 3.0, 'keterangan' => 'Kompetensi individu kekurangan 2 tingkat'],
            ['selisih' => 3, 'bobot' => 2.5, 'keterangan' => 'Kompetensi individu kelebihan 3 tingkat'],
            ['selisih' => -3, 'bobot' => 2.0, 'keterangan' => 'Kompetensi individu kekurangan 3 tingkat'],
            ['selisih' => 4, 'bobot' => 1.5, 'keterangan' => 'Kompetensi individu kelebihan 4 tingkat'],
            ['selisih' => -4, 'bobot' => 1.0, 'keterangan' => 'Kompetensi individu kekurangan 4 tingkat'],
        ]);

        // Kriteria
        DB::table('kriteria')->insert([
            ['kode' => 'K1', 'nama' => 'Aspek Teknis Pekerjaan', 'bobot' => 35.00, 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'K2', 'nama' => 'Aspek Non Teknis', 'bobot' => 25.00, 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'K3', 'nama' => 'Aspek Kepribadian', 'bobot' => 25.00, 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'K4', 'nama' => 'Aspek Kepemimpinan', 'bobot' => 15.00, 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Sub Kriteria - ASPEK TEKNIS
        DB::table('sub_kriteria')->insert([
            ['kriteria_id' => 1, 'kode' => 'K1.1', 'nama' => 'Efektifitas dan Efisiensi Kerja', 'tipe' => 'core', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 1, 'kode' => 'K1.2', 'nama' => 'Ketepatan waktu dalam menyelesaikan tugas', 'tipe' => 'core', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 1, 'kode' => 'K1.3', 'nama' => 'Kemampuan mencapai target/standar perusahaan', 'tipe' => 'core', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Sub Kriteria - ASPEK NON TEKNIS
        DB::table('sub_kriteria')->insert([
            ['kriteria_id' => 2, 'kode' => 'K2.1', 'nama' => 'Tertib Administrasi', 'tipe' => 'core', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 2, 'kode' => 'K2.2', 'nama' => 'Inisiatif (Tindakan, Saran, Ide dalam melakukan Pekerjaan)', 'tipe' => 'core', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 2, 'kode' => 'K2.3', 'nama' => 'Kerjasama & Koordinasi antar bagian', 'tipe' => 'secondary', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 2, 'kode' => 'K2.4', 'nama' => 'Tertib Kehadiran/Absensi', 'tipe' => 'core', 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Sub Kriteria - ASPEK KEPRIBADIAN
        DB::table('sub_kriteria')->insert([
            ['kriteria_id' => 3, 'kode' => 'K3.1', 'nama' => 'Perilaku', 'tipe' => 'core', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 3, 'kode' => 'K3.2', 'nama' => 'Kedisiplinan', 'tipe' => 'core', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 3, 'kode' => 'K3.3', 'nama' => 'Tanggung Jawab & Loyalitas', 'tipe' => 'core', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 3, 'kode' => 'K3.4', 'nama' => 'Ketaatan terhadap Instruksi kerja atasan', 'tipe' => 'secondary', 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Sub Kriteria - ASPEK KEPEMIMPINAN
        DB::table('sub_kriteria')->insert([
            ['kriteria_id' => 4, 'kode' => 'K4.1', 'nama' => 'Koordinasi anggota', 'tipe' => 'core', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 4, 'kode' => 'K4.2', 'nama' => 'Kontrol Anggota', 'tipe' => 'core', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 4, 'kode' => 'K4.3', 'nama' => 'Evaluasi, Pembinaan anggota & Pelatihan', 'tipe' => 'core', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 4, 'kode' => 'K4.4', 'nama' => 'Delegasi tanggung Jawab, wewenang & Pemantauan', 'tipe' => 'secondary', 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_id' => 4, 'kode' => 'K4.5', 'nama' => 'Kecepatan & Ketepatan Pengambilan Keputusan', 'tipe' => 'core', 'urutan' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Profil Ideal
        for ($i = 1; $i <= 16; $i++) {
            DB::table('profil_ideal')->insert([
                'sub_kriteria_id' => $i,
                'nilai_ideal' => ($i == 6 || $i == 11 || $i == 15) ? 16 : 18,
                'keterangan' => 'Target ideal untuk sub kriteria ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Periode Penilaian
        DB::table('periode_penilaian')->insert([
            'nama' => 'Periode I/2026',
            'tahun' => 2026,
            'triwulan' => 'I',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-03-31',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sample Karyawan
        DB::table('karyawan')->insert([
            ['nik' => 'WTR001', 'nama' => 'Budi Santoso', 'jabatan' => 'Manager Produksi', 'unit_kerja' => 'Teknis/Marketing/Keuangan/Umum', 'tanggal_masuk' => '2020-01-15', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nik' => 'WTR002', 'nama' => 'Siti Nurhaliza', 'jabatan' => 'Supervisor Quality Control', 'unit_kerja' => 'Teknis/Marketing/Keuangan/Umum', 'tanggal_masuk' => '2019-06-20', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nik' => 'WTR003', 'nama' => 'Ahmad Hidayat', 'jabatan' => 'Staff Marketing', 'unit_kerja' => 'Teknis/Marketing/Keuangan/Umum', 'tanggal_masuk' => '2021-03-10', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nik' => 'WTR004', 'nama' => 'Dewi Lestari', 'jabatan' => 'Staff HRD', 'unit_kerja' => 'Dir/Man/Ass.Man/Staff/Supp.Staff', 'tanggal_masuk' => '2020-09-01', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nik' => 'WTR005', 'nama' => 'Rudi Hermawan', 'jabatan' => 'Operator Produksi', 'unit_kerja' => 'Teknis/Marketing/Keuangan/Umum', 'tanggal_masuk' => '2022-01-05', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}