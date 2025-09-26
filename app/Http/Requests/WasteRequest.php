<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WasteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'household_id' => 'required|string|exists:households,_id',
            'type'         => 'required|in:organic,plastic,paper,electronic',
            'pickup_date'  => 'nullable|date',
            'status'       => 'nullable|in:pending,scheduled,completed,canceled',
            'safety_check' => 'nullable|boolean',
        ];
    }
}
