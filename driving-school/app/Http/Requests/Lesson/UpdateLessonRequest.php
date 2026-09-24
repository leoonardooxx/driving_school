<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date', 'after_or_equal:start_date'],
            'type' => ['sometimes', 'in:teoric,pratical'],
            'active' => ['sometimes', 'boolean'],
            'instructor_id' => ['sometimes', 'integer', Rule::exists('users', 'id')->where('profile', 'instructor')],
            'vehicle_id' => [
                Rule::requiredIf(fn () => $this->input('type', $this->lesson->type) === 'pratical'
                    && ($this->has('vehicle_id') || !$this->lesson->vehicle_id)),
                'nullable',
                'integer',
                'exists:vehicles,id',
            ],
        ];
    }
}
