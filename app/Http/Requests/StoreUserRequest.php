<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
                'regex:/^[a-zA-Z\s\-\.]+$/' // Only letters, spaces, hyphens, and dots
            ],
            'username' => [
                'nullable',
                'string',
                'max:255',
                'min:3',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/' // Only alphanumeric and underscore
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/' // Must contain: lowercase, uppercase, digit, special char
            ],
            'role' => [
                'required',
                'in:induk,daerah,umum'
            ],
            'region_id' => [
                Rule::requiredIf(function () {
                    return $this->input('role') === 'daerah';
                }),
                'nullable',
                'exists:regions,id'
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^\+?[0-9\s\-()]*$/'
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
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'name.min' => 'Nama minimal 3 karakter.',
            'name.regex' => 'Nama hanya boleh mengandung huruf, spasi, tanda hubung, dan titik.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 255 karakter.',
            'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial (@$!%*?&).',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'region_id.required' => 'Daerah wajib dipilih untuk user dengan role daerah.',
            'region_id.exists' => 'Daerah yang dipilih tidak ditemukan.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
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
            'name' => 'Nama Lengkap',
            'username' => 'Username',
            'password' => 'Password',
            'password_confirmation' => 'Konfirmasi Password',
            'role' => 'Role',
            'region_id' => 'Daerah',
            'phone' => 'Nomor Telepon',
        ];
    }
}
