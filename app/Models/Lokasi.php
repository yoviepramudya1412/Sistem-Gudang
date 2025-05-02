<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lokasi';

    protected $fillable = [
        'nama_lokasi',
        'kode_lokasi',
        'gedung',
        'lantai',
        'ruangan',
        'keterangan',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }

    public function mutasiAsal()
    {
        return $this->hasMany(MutasiBarang::class, 'lokasi_asal_id');
    }

    public function mutasiTujuan()
    {
        return $this->hasMany(MutasiBarang::class, 'lokasi_tujuan_id');
    }
}
