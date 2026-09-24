<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'payed_date' => ['sometimes', 'nullable', 'date'],
            'expiration_date' => ['sometimes', 'date', 'after_or_equal:payed_date'],
            'active' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'in:PENDING,PAID,EXPIRED'],
            'reference' => ['sometimes', 'string', 'unique:payments,reference,' . $this->payment->id],
            'notes' => ['sometimes', 'nullable', 'string'],

        ];
    }
}
