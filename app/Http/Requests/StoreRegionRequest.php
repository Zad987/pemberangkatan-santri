<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:regions,name',
                'regex:/^[a-zA-Z\s\-\.]+$/'
            ],
            'code' => [
                'nullable',
                'string',
                'max:10',
                'unique:regions,code',
                'regex:/^[A-Z0-9\-]+$/'
            ],
            'description' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama daerah wajib diisi.',
            'name.string' => 'Nama daerah harus berupa teks.',
            'name.max' => 'Nama daerah maksimal 255 karakter.',
            'name.min' => 'Nama daerah minimal 3 karakter.',
            'name.unique' => 'Nama daerah sudah ada.',
            'name.regex' => 'Nama daerah hanya boleh mengandung huruf, spasi, tanda hubung, dan titik.',
            'code.max' => 'Kode daerah maksimal 10 karakter.',
            'code.unique' => 'Kode daerah sudah ada.',
            'code.regex' => 'Kode daerah hanya boleh mengandung huruf besar, angka, dan tanda hubung.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Daerah',
            'code' => 'Kode Daerah',
            'description' => 'Deskripsi',
        ];
    }
}
