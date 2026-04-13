<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'environment_id' => $this->environment_id,
            // 'credentials_count' => $this->credentials_count ?? 0,
            'created_at' => $this->created_at->toIsoString(),

            // 'credential_summary' => $this->whenLoaded('credentials', fn () => $this->credentials
            //     ->groupBy('category.name')
            //     ->map->count()
            // ),

        ];
    }
}
