<?php

namespace App\Http\Requests\V1\Order;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\V1\Order\OrderTrackingStatusEnum;

class TrackOrderStatusRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'order_item_id' => ['required', 'exists:order_items,id'],
      'status' => ['required', new Enum(OrderTrackingStatusEnum::class)]
    ];
  }
}
