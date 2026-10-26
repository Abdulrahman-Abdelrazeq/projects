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
            'shop_name' => $this->shop_name,
            'image' => asset('storage/' . $this->image),
            'out_link' => asset('storage/' . $this->image),
            'link_api' => $this->link_api,
            'shop_code' => $this->shop_code,
            'domain' => $this->link_api . '/' . $this->shop_code,
            'address' => $this->address,
            'active' => $this->active ?? '',
        ];
    }
}