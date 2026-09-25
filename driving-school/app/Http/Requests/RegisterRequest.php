<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|',
            'name' => 'required|string|min:8|max:20',
            'password' => ['required', Password::defaults()],
            'last_name' => 'required|string|min:8|max:20',
            'profile' => ['required', Rule::in(['admin', 'student', 'instructor'])],
            'nif' => 'required|digits:9',
        ];
    }
}
