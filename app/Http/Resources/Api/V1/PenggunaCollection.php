<?php


namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PenggunaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'role' => $this->role,
            'nomor_telepon' => $this->nomor_telepon,
            'alamat' => $this->alamat,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.v1.pengguna.show', $this->id),
                'mutasi' => route('api.v1.pengguna.riwayat-mutasi', $this->id),
            ],
        ];
    }
}
