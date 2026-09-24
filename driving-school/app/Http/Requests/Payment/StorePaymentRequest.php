<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => ['required', 'numeric', 'min:0'],
            'payed_date' => ['nullable', 'date'],
            'expiration_date' => ['required', 'date', 'after_or_equal:payed_date'],
            'active' => ['nullable', 'boolean'],
            'status' => ['required', 'in:PENDING,PAID,EXPIRED'],
            'reference' => ['required', 'string', 'unique:payments,reference'],
            'notes' => ['nullable', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
