<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok';

    protected $fillable = [
        'barang_id',
        'mutasi_id',
        'stok_sebelumnya',
        'perubahan_stok',
        'stok_sekarang',
        'tipe_perubahan',
        'pengguna_id',
        'keterangan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function mutasi()
    {
        return $this->belongsTo(MutasiBarang::class, 'mutasi_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
