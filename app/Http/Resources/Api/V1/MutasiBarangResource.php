<?php


namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MutasiBarangResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tanggal_mutasi' => $this->tanggal_mutasi->format('Y-m-d'),
            'jenis_mutasi' => $this->jenis_mutasi,
            'jumlah' => $this->jumlah,
            'nomor_referensi' => $this->nomor_referensi,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            'barang' => [
                'id' => $this->barang->id,
                'nama_barang' => $this->barang->nama_barang,
                'kode_barang' => $this->barang->kode_barang,
            ],
            'pengguna' => [
                'id' => $this->pengguna->id,
                'nama_lengkap' => $this->pengguna->nama_lengkap,
            ],
            'lokasi_asal' => $this->lokasiAsal ? [
                'id' => $this->lokasiAsal->id,
                'nama_lokasi' => $this->lokasiAsal->nama_lokasi,
            ] : null,
            'lokasi_tujuan' => $this->lokasiTujuan ? [
                'id' => $this->lokasiTujuan->id,
                'nama_lokasi' => $this->lokasiTujuan->nama_lokasi,
            ] : null,
            
            'links' => [
                'self' => route('api.v1.mutasi-barang.show', $this->id),
            ],
        ];
    }
}
