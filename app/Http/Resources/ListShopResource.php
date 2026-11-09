<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shop_name' => $this->shop_name,
            'image' => asset('storage/' . $this->image),
            'out_link' => asset('storage/' . $this->image),
            'link_api' => $this->link_api,
            'shop_code' => $this->shop_code,
            'domain' => $this->link_api . '/' . $this->shop_code,
            'address' => $this->address ?? '',
            'phone' => $this->phone ?? '',
            'shop_type' => $this->shop_type ?? '',
            'sort_order' => $this->sort_order ?? 0,
            'active' => $this->active ?? '',
        ];
    }
}
