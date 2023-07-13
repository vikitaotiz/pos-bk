<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            "status" => $this->status,
            "selling_price" => $this->selling_price,
            "sales" => $this->sales->map->only('uuid', 'name', 'quantity'),
            "payment_mode" => $this->payment_mode ? $this->payment_mode->name : "No User",
            "user" => $this->user ? $this->user->name : "No User",
            "created_at" => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
