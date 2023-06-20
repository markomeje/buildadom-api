<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rules\Password;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerPaymentRequest extends FormRequest
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
      'type' => ['required', 'string', 'unique:users'],
      'amount' => ['required', 'unique:users'],
      'firstname' => ['required', 'string', 'max:50'],
      'lastname' => ['required', 'string', 'max:50'],
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
