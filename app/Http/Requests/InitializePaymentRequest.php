<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rules\Password;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class InitializePaymentRequest extends FormRequest
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
      'order_id' => ['required', 'exists:orders,id'],
      'amount' => ['required', 'gt:0'],
    ];
  }

 /**
 * Custom message for validation
 *
 * @return array
 */
 public function messages()
 {
    return [];
 }
}
