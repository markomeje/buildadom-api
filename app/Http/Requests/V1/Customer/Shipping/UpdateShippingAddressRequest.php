<?php

namespace App\Http\Requests\V1\Customer\Shipping;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateShippingAddressRequest extends FormRequest
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
      'city_id' => ['required', 'integer', Rule::exists('cities', 'id')],
      'country_id' => ['required', 'integer', Rule::exists('countries', 'id')],
      'state_id' => ['required', 'integer', Rule::exists('states', 'id')],
      'street_address' => ['required', 'string'],
      'zip_code' => ['required', 'string'],
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
    ], 'Please check your payload.');

    throw new ValidationException($validator, $response);
  }
}
