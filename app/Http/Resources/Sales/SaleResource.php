<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            "quantity" => $this->quantity,
            "status" => $this->status,
            "user" => $this->user ? $this->user->name: "No user",
            "created_at" => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
