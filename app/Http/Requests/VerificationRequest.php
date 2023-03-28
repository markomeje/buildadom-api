<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class VerificationRequest extends FormRequest
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
      'code' => ['required', 'min:6', 'max:6'],
      'type' => ['required']
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
      'type.required' => 'Type can either be phone or email.',
    ];
  }
}














