<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user'); // Retrieve the user ID from the route

        return [
            'name' => ['required', 'max:255', 'min:5', 'string'],
            'email' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'role' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                Rule::in([0, 1])
            ],
            'password' => ['nullable', 'min:8', 'confirmed', Password::defaults()]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'name.min' => 'Nama minimal 5 karakter',
            'name.string' => 'Nama harus berupa string',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role harus diisi',
            'role.in' => 'Role harus 0 atau 1',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.string' => 'Password harus berupa string'
        ];
    }
}
