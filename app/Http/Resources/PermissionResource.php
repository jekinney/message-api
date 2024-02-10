<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Has when has set so we can get a list of ids only when needed
        return [
            'id' => $this->id,
            'slug' => $this->whenHas('slug'),
            'display_name' => $this->whenHas('display_name'),
            'description' => $this->whenHas('description'),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
