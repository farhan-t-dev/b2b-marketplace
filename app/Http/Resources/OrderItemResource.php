<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price_snapshot' => $this->price_snapshot,
            'variant' => new ProductVariantResource($this->whenLoaded('variant')),
        ];
    }
}
