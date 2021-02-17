<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BudgetResource extends Resource
{
    const ITEMS_PER_PAGE = 5;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'status' => $this->statusLabel,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
