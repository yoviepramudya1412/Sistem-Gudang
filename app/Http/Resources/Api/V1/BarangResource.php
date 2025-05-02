<?php


namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'stok' => $this->stok,
            'stok_minimal' => $this->stok_minimal,
            'satuan' => $this->satuan,
            'status' => $this->status,
            'gambar_url' => $this->gambar ? asset('storage/' . $this->gambar) : null,
            'tanggal_kadaluarsa' => $this->tanggal_kadaluarsa?->format('Y-m-d'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            'kategori' => [
                'id' => $this->kategori->id,
                'nama_kategori' => $this->kategori->nama_kategori,
                'kode_kategori' => $this->kategori->kode_kategori,
            ],
            'lokasi' => [
                'id' => $this->lokasi->id,
                'nama_lokasi' => $this->lokasi->nama_lokasi,
                'kode_lokasi' => $this->lokasi->kode_lokasi,
            ],
            
            'links' => [
                'self' => route('api.v1.barang.show', $this->id),
                'mutasi' => route('api.v1.mutasi-barang.index', ['barang_id' => $this->id]),
                'riwayat_stok' => route('api.v1.barang.riwayat-stok', $this->id),
            ],
        ];
    }
}
