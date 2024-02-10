<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'body' => $this->body,
            'author' => new UserPartialResource($this->author),
            'is_deleted' => $this->deleted_at? true:false,
            'created_at' => $this->created_at->format('m/d/Y H:s a')
        ];
    }
}
