<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\EmailRule;


class LoginRequest extends FormRequest
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
      'email' => ['required', 'email', (new EmailRule)],
      'password' => ['required', 'string'],
    ];
  }

}



