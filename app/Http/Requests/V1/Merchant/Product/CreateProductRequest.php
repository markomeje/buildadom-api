<?php

namespace App\Http\Requests\V1\Merchant\Product;
use App\Utility\Responser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateProductRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:50'],
      'description' => ['required', 'string', 'max:500'],
      'store_id' => ['required', 'exists:stores,id'],
      'price' => ['required', 'numeric', 'gt:0'],
      'product_category_id' => ['required', 'exists:product_categories,id'],
      'quantity' => ['required', 'integer'],
      'attributes' => ['nullable'],
      'currency_id' => ['required', 'exists:currencies,id'],
      'product_unit_id' => ['required', 'exists:product_units,id'],
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
