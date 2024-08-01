<?php

namespace App\Http\Requests\V1\Logistics;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateLogisticsCompanyRequest extends FormRequest
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
      'plate_number' => ['required', 'string', Rule::unique('logistics_companies')],
      'drivers_license' => ['required', 'file', 'mimes:jpg,jpeg,png'],
      'vehicle_picture' => ['required', 'file', 'mimes:jpg,jpeg,png'],
      'driver_picture' => ['required', 'file', 'mimes:jpg,jpeg,png'],
      'city_id' => ['required', Rule::exists('cities', 'id')],
      'state_id' => ['required', Rule::exists('states', 'id')],
      'phone_number' => ['required', 'string', Rule::unique('logistics_companies')],
      'base_price' => ['required', 'gt:0'],
      'park_address' => ['required', 'string', 'max:250'],
    ];
  }
}
