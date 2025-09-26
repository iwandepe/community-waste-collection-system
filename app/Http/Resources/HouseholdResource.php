<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HouseholdResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => (string) $this->_id,
            'owner_name' => $this->owner_name,
            'address'    => $this->address,
            'block'      => $this->block,
            'no'         => $this->no,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
