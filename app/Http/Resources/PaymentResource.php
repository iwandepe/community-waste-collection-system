<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => (string) $this->_id,
            'household_id' => (string) $this->household_id,
            'amount'       => (float) $this->amount,
            'status'       => $this->status,
            'payment_date' => $this->payment_date?->toDateTimeString(),
            'created_at'   => $this->created_at?->toDateTimeString(),
            'updated_at'   => $this->updated_at?->toDateTimeString(),
        ];
    }
}
