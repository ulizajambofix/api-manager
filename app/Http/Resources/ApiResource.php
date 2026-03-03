<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'base_url' => $this->base_url,
            'status' => $this->status,
            'rate_limit_per_minute' => $this->rate_limit_per_minute,
            'versions' => $this->whenLoaded('versions'),
            'created_at' => $this->created_at,
        ];
    }
}
