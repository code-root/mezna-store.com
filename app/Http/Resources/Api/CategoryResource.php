<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isCollection = $request->route() && str_contains($request->route()->getName(), 'api.categories.index');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'hide_price' => (bool) $this->hide_price,
            'visits_count' => isset($this->visit_logs_count) ? (int) $this->visit_logs_count : $this->visitLogs()->count(),
            'products_count' => $isCollection ? $this->products()->count() : null,
            'banners_count' => $isCollection ? $this->banners()->count() : null,
            'products' => $this->when(!$isCollection && $this->relationLoaded('products'), function () {
                $hidePrice = (bool) $this->hide_price;
                return $this->products->map(function ($product) use ($hidePrice) {
                    $item = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'image' => $product->image,
                        'visits_count' => isset($product->visit_logs_count) ? (int) $product->visit_logs_count : $product->visitLogs()->count(),
                    ];
                    if (!$hidePrice) {
                        $item['price'] = $product->price;
                    }
                    return $item;
                });
            }),
            'banners' => $this->when(!$isCollection && $this->relationLoaded('banners'), function () {
                return $this->banners->map(function ($banner) {
                    return [
                        'id' => $banner->id,
                        'title' => $banner->title,
                        'description' => $banner->description,
                        'image' => $banner->image,
                        'link' => $banner->link,
                    ];
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
