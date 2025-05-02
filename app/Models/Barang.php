<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'stok',
        'stok_minimal',
        'satuan',
        'tanggal_kadaluarsa',
        'merek',
        'nomor_seri',
        'spesifikasi',
        'keterangan',
        'gambar',
        'status',
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function mutasi()
    {
        return $this->hasMany(MutasiBarang::class, 'barang_id');
    }

    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class, 'barang_id');
    }
}