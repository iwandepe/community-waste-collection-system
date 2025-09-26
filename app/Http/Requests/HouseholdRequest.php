<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseholdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // enable for now, can add auth later
    }

    public function rules(): array
    {
        return [
            'owner_name' => 'required|string|max:255',
            'address'    => 'required|string|max:500',
            'block'      => 'nullable|string|max:50',
            'no'         => 'nullable|string|max:50',
        ];
    }
}
