<?php

namespace App\Http\Resources\V1\Fee;
use App\Http\Resources\CurrencyResource;
use App\Traits\V1\Fee\FeeSettingTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeSettingResource extends JsonResource
{
  use FeeSettingTrait;

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
      'code' => $this->code,
      'amount' => $this->amount,
      'type' => $this->type,
      'description' => $this->convertToReadable($this->code),
      'currency' => new CurrencyResource($this->whenLoaded('currency')),
    ];
  }
}
