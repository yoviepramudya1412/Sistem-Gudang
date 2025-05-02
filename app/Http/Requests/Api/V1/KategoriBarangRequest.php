<?php


namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 

class KategoriBarangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'nama_kategori' => 'required|string|max:255',
        'kode_kategori' => [
            'required',
            'string',
            'max:50',
            Rule::unique('kategori_barang')->ignore($this->kategori_barang ? $this->kategori_barang->id : null)
        ],
        'deskripsi' => 'nullable|string',
    ];
}
}