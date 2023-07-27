<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:500'],
      'store_id' => ['required', 'exists:stores,id'],
      'price' => ['required', 'integer'],
      'category_id' => ['required', 'exists:categories,id'],
      'quantity' => ['required', 'integer'],
      'attributes' => ['nullable'],
      'currency_id' => ['required', 'exists:currencies,id'],
      'unit_id' => ['required', 'exists:units,id'],
    ];
  }

  /**
   * Custom message for validation
   *
   * @return array
   */
  public function messages()
  {
    return [
      'currency_id.required' => 'Please select currency',
      'store_id.exists' => 'The selected store does not exist.',
      'currency_id.exists' => 'The selected currency does not exist.',
      'category_id.exists' => 'The selected category does not exist.',
    ];
  }

}
