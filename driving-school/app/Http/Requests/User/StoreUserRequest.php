<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['username' => Str::slug($this->name . $this->last_name)]);
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'unique:users,username'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'nif' => ['required', 'string', 'unique:users,nif'],
            'profile' => ['required', 'in:admin,student,instructor'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
