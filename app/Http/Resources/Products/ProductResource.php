<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "category" => $this->category ? $this->category->name : "No Category",
            "user" => $this->user ? $this->user->name : "No User",
            "created_at" => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
