<?php


namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class KategoriBarangResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_kategori' => $this->nama_kategori,
            'kode_kategori' => $this->kode_kategori,
            'deskripsi' => $this->deskripsi,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.v1.kategori-barang.show', $this->id),
                'barang' => route('api.v1.barang.index', ['kategori_id' => $this->id]),
            ],
        ];
    }
}
