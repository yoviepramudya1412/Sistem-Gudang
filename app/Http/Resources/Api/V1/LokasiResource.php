<?php


namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LokasiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_lokasi' => $this->nama_lokasi,
            'kode_lokasi' => $this->kode_lokasi,
            'gedung' => $this->gedung,
            'lantai' => $this->lantai,
            'ruangan' => $this->ruangan,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.v1.lokasi.show', $this->id),
                'barang' => route('api.v1.barang.index', ['lokasi_id' => $this->id]),
            ],
        ];
    }
}