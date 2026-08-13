<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisRequest extends FormRequest
{
    /**
     * Izinkan user untuk membuat request ini.
     */
    public function authorize(): bool
    {
        // Ubah jadi true agar request diizinkan
        return true; 
    }

    /**
     * Aturan validasi input.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_jenis' => 'required|string|max:255',
        ];
    }
}