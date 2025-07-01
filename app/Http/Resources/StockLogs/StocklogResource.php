<?php

namespace App\Http\Resources\StockLogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StocklogResource extends JsonResource
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
            "product_id" => $this->product_id,
            'product_name' => $this->when($this->product, $this->product?->name),
            "action_type" => $this->action_type,
            "quantity" => $this->quantity,
            "reason" => $this->reason ? $this->reason : null,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
