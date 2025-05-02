<?php


namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,staf,manajer',
            'nomor_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ];
    }
}