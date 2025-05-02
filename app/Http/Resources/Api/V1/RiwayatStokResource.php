<?php


namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatStokResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'stok_sebelumnya' => $this->stok_sebelumnya,
            'perubahan_stok' => $this->perubahan_stok,
            'stok_sekarang' => $this->stok_sekarang,
            'tipe_perubahan' => $this->tipe_perubahan,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            
            'pengguna' => [
                'id' => $this->pengguna->id,
                'nama_lengkap' => $this->pengguna->nama_lengkap,
            ],
            'mutasi' => $this->mutasi ? [
                'id' => $this->mutasi->id,
                'jenis_mutasi' => $this->mutasi->jenis_mutasi,
            ] : null,
        ];
    }
}
