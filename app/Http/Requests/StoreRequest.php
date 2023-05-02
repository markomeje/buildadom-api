<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class StoreRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255', 'unique:stores'],
      'description' => ['required', 'string', 'max:500'],
      'country_id' => ['required', 'string', 'exists:countries,id'],
      'address' => ['required', 'string', 'max:255'],
      'city' => ['required', 'string', 'max:255']
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
      'country_id.required' => 'Please select country.',
    ];
  }
}



