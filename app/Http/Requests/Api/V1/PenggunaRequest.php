<?php

// app/Http/Requests/Api/V1/PenggunaRequest.php
namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PenggunaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:pengguna,email,'.$this->pengguna->id,
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,staf,manajer',
            'nomor_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }
}