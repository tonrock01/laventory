<?php

namespace App\Http\Resources\Product;

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
            "category_id" => $this->category_id,
            "stock" => $this->stock,
            "min_stock" => $this->min_stock,
            "cost_price" => $this->cost_price,
            "sale_price" => $this->sale_price,
            "version" => $this->version,
            "created_by" => $this->created_by,
            "created_name" => $this->when($this->user, $this->user?->first_name . " " . $this->user?->last_name),
            "updated_by" => $this->updated_by,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
