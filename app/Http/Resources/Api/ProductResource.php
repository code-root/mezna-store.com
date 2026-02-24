<?php

namespace App\Http\Resources\Api;

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
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'visits_count' => isset($this->visit_logs_count) ? (int) $this->visit_logs_count : $this->visitLogs()->count(),
            'category' => $this->category && $this->relationLoaded('category') ? $this->category : null,
            'variants' => $this->variants && $this->relationLoaded('variants') ? $this->variants : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
