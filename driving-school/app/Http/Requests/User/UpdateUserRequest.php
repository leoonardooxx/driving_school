<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['sometimes', 'string', 'unique:users,username,' . $this->user->id],
            'name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'nif' => ['sometimes', 'string', 'unique:users,nif,' . $this->user->id],
            'profile' => ['sometimes', 'in:admin,student,instructor'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $this->user->id],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
