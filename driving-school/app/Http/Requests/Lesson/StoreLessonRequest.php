<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required', 'in:teoric,pratical'],
            'active' => ['nullable', 'boolean'],
            'instructor_id' => ['required', 'integer', Rule::exists('users', 'id')->where('profile', 'instructor')],
            'vehicle_id' => ['required_if:type,pratical', 'nullable', 'integer', 'exists:vehicles,id'],
        ];
    }
}
