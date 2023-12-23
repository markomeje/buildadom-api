<?php

namespace App\Http\Requests\V1\Merchant\Auth;
use App\Rules\EmailRule;
use App\Utility\Responser;
use App\Enums\User\UserTypeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class MerchantSignupRequest extends FormRequest
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
    $business = strtolower($this->type ?? '') === 'business';
    return [
      'type' => ['required', 'string', new Enum(UserTypeEnum::class)],
      'email' => ['required', 'email', 'unique:users', (new EmailRule)],
      'phone' => ['required', 'unique:users', 'phone'],
      'firstname' => [!$business ? 'required' : 'nullable', 'string', 'max:50'],
      'lastname' => [!$business ? 'required' : 'nullable', 'string', 'max:50'],

      'business_name' => [$business ? 'required' : 'nullable', 'max:255'],
      'cac_number' => [$business ? 'required' : 'nullable', 'max:20'],
      'website' => ['nullable', 'max:255'],

      'address' => ['required', 'max:255'],
      'password' => ['required', app()->environment(['production']) ? Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised() : 'min:5'],
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
      'cac_number.required' => 'Please enter your CAC registration number.',
      'phone.phone' => 'Invalid phone number. Please include country code and try again.'
    ];
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
    $response = Responser::send(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [
      'errors' => $validator->errors()
    ], 'Please check your inputs.');

    throw new ValidationException($validator, $response);
  }
}














