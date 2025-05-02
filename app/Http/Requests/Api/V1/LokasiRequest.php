<?php


namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LokasiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    $rules = [
        'nama_lokasi' => 'required|string|max:255',
        'kode_lokasi' => [
            'required',
            'string',
            'max:50',
            Rule::unique('lokasi')->ignore($this->lokasi ? $this->lokasi->id : null)
        ],
        'gedung' => 'nullable|string|max:100',
        'lantai' => 'nullable|string|max:20',
        'ruangan' => 'nullable|string|max:50',
        'keterangan' => 'nullable|string',
    ];

    return $rules;
}
}
