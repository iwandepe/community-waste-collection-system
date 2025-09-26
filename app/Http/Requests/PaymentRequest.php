<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'household_id' => 'required|string|exists:households,_id',
            'amount'       => 'required|numeric|min:0',
            'status'       => 'required|in:pending,paid,failed',
            'payment_date' => 'nullable|date',
        ];
    }
}
