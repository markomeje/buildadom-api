<?php

namespace App\Http\Requests\V1\Merchant\Store;
use App\Utility\Responser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateStoreRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:50', Rule::unique('stores')->ignore($this->id)],
      'description' => ['required', 'string', 'max:500'],

      'state_id' => ['nullable', 'integer', Rule::exists('states', 'id')],
      'city_id' => ['nullable', 'integer', Rule::exists('cities', 'id')],

      'country_id' => ['required', 'integer', Rule::exists('countries', 'id')],
      'address' => ['required', 'string', 'max:500'],
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
    $response = Responser::send(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [
      'errors' => $validator->errors()
    ], 'Please check your inputs.');

    throw new ValidationException($validator, $response);
  }
}
