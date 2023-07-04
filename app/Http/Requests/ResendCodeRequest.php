<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class ResendCodeRequest extends FormRequest
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
      'user' => ['required'],
      'type' => ['required', 'string']
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














