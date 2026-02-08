<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        // Admin bisa mengubah siapa saja; user biasa hanya boleh mengubah dirinya sendiri
        return $user && ($user->isAdmin() || $user->id === (int) $this->route('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');
        $user = $this->user();
        $isAdmin = $user && $user->isAdmin();
        
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'min:3',
                'regex:/^[a-zA-Z\\s\\-\\.]+$/'
            ],
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('users', 'username')->ignore($userId),
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'role' => $isAdmin
                ? ['sometimes', 'required', Rule::in(['induk', 'daerah', 'umum'])]
                : ['prohibited'],
            'region_id' => $isAdmin
                ? ['nullable', 'exists:regions,id']
                : ['prohibited'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^\\+?[0-9\\s\\-()]*$/'
            ],
            'is_active' => $isAdmin
                ? ['sometimes', 'boolean']
                : ['prohibited'],
            'password' => [
                'sometimes',
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
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
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'role.prohibited' => 'Anda tidak boleh mengubah role.',
            'region_id.exists' => 'Daerah yang dipilih tidak ditemukan.',
            'region_id.prohibited' => 'Anda tidak boleh mengubah wilayah.',
            'is_active.prohibited' => 'Anda tidak boleh mengubah status aktif.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ];
    }
}
