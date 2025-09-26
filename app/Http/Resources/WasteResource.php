<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WasteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => (string) $this->_id,
            'household_id' => (string) $this->household_id,
            'type'         => $this->type,
            'status'       => $this->status,
            'pickup_date'  => $this->pickup_date?->toDateTimeString(),
            'safety_check' => $this->safety_check ?? null,
            'created_at'   => $this->created_at?->toDateTimeString(),
            'updated_at'   => $this->updated_at?->toDateTimeString(),
        ];
    }
}
