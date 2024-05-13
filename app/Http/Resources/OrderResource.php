<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'client_id' => $this->client_id,
            'delivery_at' => $this->delivery_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'order_items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
