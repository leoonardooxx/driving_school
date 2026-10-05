<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Only the fields listed here can be changed from the profile page;
     * "profile" (role) and "active" are left out on purpose.
     */
    public function rules(): array
    {
        $id = $this->user()->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'nif' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('users', 'nif')->ignore($id)],
            'image' => ['sometimes', 'image', 'max:2048'],
        ];
    }
}
