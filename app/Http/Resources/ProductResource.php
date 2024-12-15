<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'category_name' => $this->category->name, // Get category name
            'supplier_name' => $this->supplier->name, // Get supplier name
            'quantity' => $this->quantity,
            'price' => $this->price,
            'cost' => $this->cost,
            'description' => $this->description,
        ];
    }
}