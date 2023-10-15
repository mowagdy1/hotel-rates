<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
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
            'hotel_id' => $this->hotel_id,
            'date_scraped' => $this->date_scraped,
            'date_of_stay' => $this->date_of_stay,
            'rate_per_night' => $this->rate_per_night,
            'hotel' => new HotelResource($this->whenLoaded('hotel')),
        ];
    }
}
