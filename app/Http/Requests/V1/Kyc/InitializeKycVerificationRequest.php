<?php

namespace App\Http\Requests\V1\Kyc;
use App\Utility\Responser;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class InitializeKycVerificationRequest extends FormRequest
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
      'document_number' => ['required', 'string', 'max:50'],
      'fullname' => ['required', 'string', 'max:50'],
      'document_type_id' => ['required', 'int', Rule::exists('document_types', 'id')],
      'birth_country' => ['required', 'int', Rule::exists('supported_countries', 'id')],
      'citizenship_country' => ['required', 'int', Rule::exists('supported_countries', 'id')],
      'document_expiry_date' => ['required', 'string', 'date'],
      'birth_date' => ['required', 'string', 'date'],
      'address' => ['required', 'string'],
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