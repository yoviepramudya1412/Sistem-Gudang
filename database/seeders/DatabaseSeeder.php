<?php


// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use App\Models\MutasiBarang;
use App\Models\Pengguna;
use App\Models\RiwayatStok;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Kategori Barang (10 data)
        $kategoriBarang = [
            ['Alat Elektronik', 'ELK', 'Alat-alat elektronik untuk kebutuhan sehari-hari'],
            ['Obat-obatan', 'OBT', 'Obat-obatan medis dan suplemen'],
            ['Alat Tulis', 'ATK', 'Alat tulis kantor dan sekolah'],
            ['Perabotan', 'PRB', 'Perabotan kantor dan rumah tangga'],
            ['Peralatan Medis', 'MED', 'Peralatan medis dan kesehatan'],
            ['Bahan Bangunan', 'BBN', 'Material dan bahan bangunan'],
            ['Alat Kebersihan', 'KBR', 'Peralatan kebersihan dan sanitasi'],
            ['Pakaian', 'PKN', 'Pakaian dan seragam'],
            ['Makanan', 'MKN', 'Bahan makanan dan minuman'],
            ['Lain-lain', 'LLN', 'Barang lainnya yang tidak termasuk kategori']
        ];

        foreach ($kategoriBarang as $kategori) {
            KategoriBarang::create([
                'nama_kategori' => $kategori[0],
                'kode_kategori' => $kategori[1],
                'deskripsi' => $kategori[2],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Lokasi (10 data)
        $lokasi = [
            ['Gudang Utama', 'GUD-01', 'Gedung A', 'Lantai 1', 'Ruang 101', 'Gudang penyimpanan utama'],
            ['Ruang Admin', 'ADM-01', 'Gedung A', 'Lantai 2', 'Ruang 201', 'Kantor administrasi'],
            ['Ruang Operasi', 'OPR-01', 'Gedung B', 'Lantai 1', 'Ruang 102', 'Ruang operasi medis'],
            ['Ruang Penyimpanan Obat', 'RPO-01', 'Gedung B', 'Lantai 2', 'Ruang 202', 'Penyimpanan obat-obatan'],
            ['Ruang Laboratorium', 'LAB-01', 'Gedung C', 'Lantai 1', 'Ruang 103', 'Laboratorium penelitian'],
            ['Ruang ICU', 'ICU-01', 'Gedung C', 'Lantai 2', 'Ruang 203', 'Intensive Care Unit'],
            ['Ruang Radiologi', 'RAD-01', 'Gedung D', 'Lantai 1', 'Ruang 104', 'Ruang pemeriksaan radiologi'],
            ['Ruang Fisioterapi', 'FST-01', 'Gedung D', 'Lantai 2', 'Ruang 204', 'Ruang terapi fisik'],
            ['Ruang Sterilisasi', 'STR-01', 'Gedung E', 'Lantai 1', 'Ruang 105', 'Ruang sterilisasi alat'],
            ['Ruang Gawat Darurat', 'IGD-01', 'Gedung E', 'Lantai 2', 'Ruang 205', 'Instalasi Gawat Darurat']
        ];

        foreach ($lokasi as $loc) {
            Lokasi::create([
                'nama_lokasi' => $loc[0],
                'kode_lokasi' => $loc[1],
                'gedung' => $loc[2],
                'lantai' => $loc[3],
                'ruangan' => $loc[4],
                'keterangan' => $loc[5],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Pengguna (10 data)
        $pengguna = [
            ['Admin Utama', 'adminas@example.com', 'password123', 'admin', '08123456789', 'Jl. Admin No. 1'],
            ['Manager Gudang', 'manager@example.com', 'password123', 'manajer', '08234567890', 'Jl. Manager No. 2'],
            ['Staf Gudang 1', 'staf1@example.com', 'password123', 'staf', '08345678901', 'Jl. Staf No. 3'],
            ['Staf Gudang 2', 'staf2@example.com', 'password123', 'staf', '08456789012', 'Jl. Staf No. 4'],
            ['Dokter Umum', 'dokter@example.com', 'password123', 'staf', '08567890123', 'Jl. Dokter No. 5'],
            ['Perawat 1', 'perawat1@example.com', 'password123', 'staf', '08678901234', 'Jl. Perawat No. 6'],
            ['Perawat 2', 'perawat2@example.com', 'password123', 'staf', '08789012345', 'Jl. Perawat No. 7'],
            ['Apoteker', 'apoteker@example.com', 'password123', 'staf', '08890123456', 'Jl. Apoteker No. 8'],
            ['Teknisi', 'teknisi@example.com', 'password123', 'staf', '08901234567', 'Jl. Teknisi No. 9'],
            ['Security', 'security@example.com', 'password123', 'staf', '08012345678', 'Jl. Security No. 10']
        ];

        foreach ($pengguna as $user) {
            Pengguna::create([
                'nama_lengkap' => $user[0],
                'email' => $user[1],
                'password' => Hash::make($user[2]),
                'role' => $user[3],
                'nomor_telepon' => $user[4],
                'alamat' => $user[5],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Barang (10 data)
        $barang = [
            ['MON-001', 'Monitor 24 Inch', 1, 1, 15, 3, 'unit', null, 'LG', 'SN-001', 'Monitor LCD 24 inci Full HD', 'Barang baru', 'aktif'],
            ['KB-001', 'Keyboard Mechanical', 1, 2, 20, 5, 'unit', null, 'Rexus', 'SN-002', 'Keyboard mechanical RGB', 'Stok terbatas', 'aktif'],
            ['PRC-001', 'Paracetamol 500mg', 2, 4, 100, 20, 'tablet', now()->addYear(), 'Kimia Farma', 'BATCH-001', 'Obat penurun panas', 'Kadaluarsa 1 tahun', 'aktif'],
            ['KRS-001', 'Kursi Kantor', 4, 1, 12, 2, 'unit', null, 'IKEA', 'SN-003', 'Kursi ergonomis', 'Warna hitam', 'aktif'],
            ['TNG-001', 'Tensimeter Digital', 5, 3, 8, 1, 'unit', null, 'Omron', 'SN-004', 'Alat pengukur tekanan darah', 'Untuk pasien', 'aktif'],
            ['PNS-001', 'Pensil 2B', 3, 2, 50, 10, 'pcs', null, 'Faber-Castell', 'SN-005', 'Pensil ujian', 'Pack isi 12', 'aktif'],
            ['SBN-001', 'Sabun Cair', 7, 6, 30, 5, 'botol', now()->addMonths(6), 'Lifebuoy', 'BATCH-002', 'Sabun antiseptik', '500ml', 'aktif'],
            ['BJU-001', 'Seragam Dokter', 8, 5, 25, 3, 'set', null, 'Medika', 'SN-006', 'Seragam dokter warna putih', 'Ukuran all size', 'aktif'],
            ['MKN-001', 'Biskuit Energi', 9, 1, 40, 8, 'pack', now()->addMonths(3), 'Energen', 'BATCH-003', 'Makanan ringan', 'Isi 10', 'aktif'],
            ['KBL-001', 'Kabel HDMI', 1, 2, 18, 4, 'pcs', null, 'Samsung', 'SN-007', 'Kabel HDMI 2.0', 'Panjang 2m', 'aktif']
        ];

        foreach ($barang as $item) {
            Barang::create([
                'kode_barang' => $item[0],
                'nama_barang' => $item[1],
                'kategori_id' => $item[2],
                'lokasi_id' => $item[3],
                'stok' => $item[4],
                'stok_minimal' => $item[5],
                'satuan' => $item[6],
                'tanggal_kadaluarsa' => $item[7],
                'merek' => $item[8],
                'nomor_seri' => $item[9],
                'spesifikasi' => $item[10],
                'keterangan' => $item[11],
                'status' => $item[12],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Mutasi Barang (10 data)
        $mutasiBarang = [
            [now()->format('Y-m-d'), 1, 3, 'masuk', 5, null, 1, 'MUT-001', 'Penambahan stok baru', null, 'selesai'],
            [now()->format('Y-m-d'), 2, 2, 'masuk', 10, null, 2, 'MUT-002', 'Pembelian baru', null, 'selesai'],
            [now()->format('Y-m-d'), 3, 4, 'keluar', 20, 4, null, 'MUT-003', 'Penggunaan obat', null, 'selesai'],
            [now()->format('Y-m-d'), 4, 5, 'pemindahan', 2, 1, 5, 'MUT-004', 'Pemindahan ke ruang dokter', null, 'selesai'],
            [now()->format('Y-m-d'), 5, 6, 'masuk', 3, null, 3, 'MUT-005', 'Donasi alat medis', null, 'selesai'],
            [now()->format('Y-m-d'), 6, 7, 'keluar', 15, 2, null, 'MUT-006', 'Penggunaan sekolah', null, 'selesai'],
            [now()->format('Y-m-d'), 7, 8, 'penyesuaian', 5, 6, 6, 'MUT-007', 'Koreksi stok', null, 'selesai'],
            [now()->format('Y-m-d'), 8, 9, 'masuk', 10, null, 5, 'MUT-008', 'Pembelian seragam', null, 'selesai'],
            [now()->format('Y-m-d'), 9, 10, 'keluar', 8, 1, null, 'MUT-009', 'Distribusi ke pasien', null, 'selesai'],
            [now()->format('Y-m-d'), 10, 1, 'pemindahan', 5, 2, 3, 'MUT-010', 'Pemindahan ke gudang', null, 'selesai']
        ];

        foreach ($mutasiBarang as $mutasi) {
            $mb = MutasiBarang::create([
                'tanggal_mutasi' => $mutasi[0],
                'barang_id' => $mutasi[1],
                'pengguna_id' => $mutasi[2],
                'jenis_mutasi' => $mutasi[3],
                'jumlah' => $mutasi[4],
                'lokasi_asal_id' => $mutasi[5],
                'lokasi_tujuan_id' => $mutasi[6],
                'nomor_referensi' => $mutasi[7],
                'keterangan' => $mutasi[8],
                'dokumen_pendukung' => $mutasi[9],
                'status' => $mutasi[10],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update stok barang
            $barang = Barang::find($mutasi[1]);
            $stokSebelumnya = $barang->stok;
            
            if ($mutasi[3] === 'masuk') {
                $barang->stok += $mutasi[4];
            } elseif ($mutasi[3] === 'keluar') {
                $barang->stok -= $mutasi[4];
            } elseif ($mutasi[3] === 'pemindahan') {
                $barang->lokasi_id = $mutasi[6];
            }
            
            $barang->save();

            // Seed Riwayat Stok
            RiwayatStok::create([
                'barang_id' => $mutasi[1],
                'mutasi_id' => $mb->id,
                'stok_sebelumnya' => $stokSebelumnya,
                'perubahan_stok' => $mutasi[3] === 'masuk' ? $mutasi[4] : -$mutasi[4],
                'stok_sekarang' => $barang->stok,
                'tipe_perubahan' => 'mutasi_' . $mutasi[3],
                'pengguna_id' => $mutasi[2],
                'keterangan' => $mutasi[8],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}