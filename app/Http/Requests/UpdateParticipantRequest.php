<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && ($user->isAdmin() || $user->isDaerah());
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
                'sometimes',
                'required',
                'string',
                'max:255',
                'min:3',
                'regex:/^[a-zA-Z\s\-\.\']+$/'
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^\+?[0-9\s\-()]*$/'
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:255'
            ],
            'address' => [
                'nullable',
                'string',
                'max:500'
            ],
            'birth_date' => [
                'nullable',
                'date',
                'before:today',
                'after:1930-01-01'
            ],
            'gender' => [
                'nullable',
                'in:laki-laki,perempuan'
            ],
            'region_id' => [
                'sometimes',
                'required',
                'exists:regions,id'
            ],
            'category_id' => [
                'sometimes',
                'required',
                'exists:categories,id'
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
            'name.required' => 'Nama peserta wajib diisi.',
            'name.string' => 'Nama peserta harus berupa teks.',
            'name.max' => 'Nama peserta maksimal 255 karakter.',
            'name.min' => 'Nama peserta minimal 3 karakter.',
            'name.regex' => 'Nama peserta hanya boleh mengandung huruf, spasi, tanda hubung, dan titik.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'email.email' => 'Format email tidak valid.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'birth_date.after' => 'Tanggal lahir harus setelah tahun 1930.',
            'gender.in' => 'Jenis kelamin harus laki-laki atau perempuan.',
            'region_id.required' => 'Daerah wajib dipilih.',
            'region_id.exists' => 'Daerah yang dipilih tidak ditemukan.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
        ];
    }
}
