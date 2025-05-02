<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BarangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'kode_barang' => [
                'sometimes', // Hanya diperlukan jika field ada di request
                'string',
                'max:50',
                Rule::unique('barang')->ignore($this->barang)
            ],
            'nama_barang' => 'sometimes|string|max:255',
            'kategori_id' => 'sometimes|exists:kategori_barang,id',
            'lokasi_id' => 'sometimes|exists:lokasi,id',
            'stok' => 'sometimes|integer|min:0',
            'stok_minimal' => 'sometimes|integer|min:0',
            'satuan' => 'sometimes|string|max:20',
            'tanggal_kadaluarsa' => 'nullable|date',
            'merek' => 'nullable|string|max:100',
            'nomor_seri' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|in:aktif,nonaktif,kadaluarsa',
        ];

        // Untuk create, beberapa field diwajibkan
        if ($this->isMethod('POST')) {
            $rules['kode_barang'] = 'required|string|max:50|unique:barang';
            $rules['nama_barang'] = 'required|string|max:255';
            $rules['kategori_id'] = 'required|exists:kategori_barang,id';
            $rules['lokasi_id'] = 'required|exists:lokasi,id';
            $rules['stok'] = 'required|integer|min:0';
            $rules['stok_minimal'] = 'required|integer|min:0';
            $rules['satuan'] = 'required|string|max:20';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'kategori_id.exists' => 'Kategori barang tidak ditemukan',
            'lokasi_id.exists' => 'Lokasi tidak ditemukan',
        ];
    }
}