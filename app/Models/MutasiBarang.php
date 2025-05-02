<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutasiBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mutasi_barang';

    protected $fillable = [
        'tanggal_mutasi',
        'barang_id',
        'pengguna_id',
        'jenis_mutasi',
        'jumlah',
        'lokasi_asal_id',
        'lokasi_tujuan_id',
        'nomor_referensi',
        'keterangan',
        'dokumen_pendukung',
        'status',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function lokasiAsal()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_asal_id');
    }

    public function lokasiTujuan()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_tujuan_id');
    }

    public function riwayatStok()
    {
        return $this->hasOne(RiwayatStok::class, 'mutasi_id');
    }
}
