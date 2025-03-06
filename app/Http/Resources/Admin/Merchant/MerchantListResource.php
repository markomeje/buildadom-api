<?php

namespace App\Http\Resources\Admin\Merchant;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantListResource extends JsonResource
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
      'firstname' => $this->firstname,
      'lastname' => $this->lastname,
      'type' => $this->type,
      'address' => $this->address,
      'email' => $this->email,
      'phone' => $this->phone,
      'status' => $this->status,
    ];
  }
}
