<?php

namespace App\Http\Requests;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateShippingRequest extends FormRequest
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
      'street_address' => ['required', 'string', 'max:255'],
      'city' => ['required', 'string', 'max:50'],
      'state' => ['required', 'string', 'max:50'],
      'country_id' => ['required'],
      'phone' => ['required', 'unique:users', 'phone'],
      'email' => ['required', 'email', 'unique:users', (new EmailRule)],
      'firstname' => ['required', 'string', 'max:255'],
      'lastname' => ['required', 'string', 'max:255'],
      'zip_code' => ['required'],
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
      'zip_code.required' => 'Zip or postal code is required',
      'state.required' => 'State or province is required',
      'phone.phone' => 'Invalid phone number. Please include country code and try again.',
      'country_id.required' => 'Please select shipping country.',
    ];
  }
}
