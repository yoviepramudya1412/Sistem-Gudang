<?php

// app/Http/Requests/Api/V1/MutasiBarangRequest.php
namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MutasiBarangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tanggal_mutasi' => 'required|date',
            'barang_id' => 'required|exists:barang,id',
            'jenis_mutasi' => 'required|in:masuk,keluar,pemindahan,penyesuaian',
            'jumlah' => 'required|integer|min:1',
            'lokasi_asal_id' => [
                'nullable',
                'required_if:jenis_mutasi,pemindahan',
                'exists:lokasi,id',
                Rule::when($this->jenis_mutasi === 'pemindahan', [
                    'different:lokasi_tujuan_id'
                ])
            ],
            'lokasi_tujuan_id' => [
                'nullable',
                'required_if:jenis_mutasi,masuk,pemindahan',
                'exists:lokasi,id'
            ],
            'nomor_referensi' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'status' => 'sometimes|in:draft,diproses,selesai,dibatalkan',
        ];
    }

    public function messages()
    {
        return [
            'lokasi_asal_id.different' => 'Lokasi asal dan tujuan tidak boleh sama',
            'barang_id.exists' => 'Barang tidak ditemukan',
            'lokasi_asal_id.exists' => 'Lokasi asal tidak ditemukan',
            'lokasi_tujuan_id.exists' => 'Lokasi tujuan tidak ditemukan',
        ];
    }
}
