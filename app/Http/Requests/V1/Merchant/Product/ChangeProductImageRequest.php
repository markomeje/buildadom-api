<?php

namespace App\Http\Requests\V1\Merchant\Product;
use App\Utility\Responser;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ChangeProductImageRequest extends FormRequest
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
      'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
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
   * @param Validator $validator
   * @return void
   */
  protected function failedValidation(Validator $validator)
  {
    $response = Responser::send(Status::HTTP_UNPROCESSABLE_ENTITY, [
      'errors' => $validator->errors()
    ], 'Kindly check the pics you are trying to upload.');

    throw new ValidationException($validator, $response);
  }
}