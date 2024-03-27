<?php

namespace App\Http\Requests\V1\Customer\Auth;
use App\Rules\EmailRule;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

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
 * @return array
 */
  public function rules()
  {
    return [
      'email' => ['required', 'email', (new EmailRule)],
      'password' => ['required', app()->environment(['production']) ? Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised() : 'min:4'],
      'confirm_password' => ['required', 'same:password'],
      'firstname' => ['required', 'string', 'max:255'],
      'lastname' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', Rule::unique('users')],
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

  /**
   * Customize failed validation json response
   *
   * @return void
   *
   * @param Validator
   */
  protected function failedValidation(Validator $validator)
  {
    $response = Responser::send(Status::HTTP_UNPROCESSABLE_ENTITY, [
      'errors' => $validator->errors()
    ], 'Please check your inputs.');

    throw new ValidationException($validator, $response);
  }
}
