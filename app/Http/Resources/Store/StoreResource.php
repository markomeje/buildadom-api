<?php

declare(strict_types=1);

namespace App\Http\Resources\Store;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryStateResource;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'banner' => $this->banner,
            'published' => $this->published,
            'address' => $this->address,
            'logo' => $this->logo,
            'extras' => $this->extras,
            'country' => new CountryResource($this->whenLoaded('country')),
            'state' => new CountryStateResource($this->whenLoaded('state')),
            'city' => new CityResource($this->whenLoaded('state')),
        ];
    }
}
