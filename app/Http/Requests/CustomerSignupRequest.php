<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rules\Password;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerSignupRequest extends FormRequest
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
      'email' => ['required', 'email', 'unique:users', (new EmailRule)],
      'phone' => ['required', 'unique:users', 'phone'],
      'firstname' => ['required', 'string', 'max:50'],
      'lastname' => ['required', 'string', 'max:50'],

      'password' => ['required', app()->environment(['production']) ? Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised() : 'min:8'],
      'confirm_password' => ['required', 'same:password']
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
      'phone.phone' => 'Invalid phone number. Please include country code and try again.'
    ];
  }
}
