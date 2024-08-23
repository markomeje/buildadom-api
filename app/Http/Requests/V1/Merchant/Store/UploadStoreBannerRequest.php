<?php

namespace App\Http\Requests\V1\Merchant\Store;
use App\Enums\Store\StoreUploadTypeEnum;
use App\Utility\Responser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class UploadStoreBannerRequest extends FormRequest
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
      'banner' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
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
    $response = responser()->send(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [
      'errors' => $validator->errors()
    ], 'Kindly check the banner you are trying to upload.');

    throw new ValidationException($validator, $response);
  }
}
