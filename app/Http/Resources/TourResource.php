<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'travel_id' => $this->travel_id,
            'name' => $this->name,
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'price_in_cents' => number_format($this->price_in_cents, 2),
        ];
    }
}
