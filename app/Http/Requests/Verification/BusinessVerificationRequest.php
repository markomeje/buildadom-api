<?php

namespace App\Http\Requests\Verification;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Enums\User\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class BusinessVerificationRequest extends FormRequest
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
      'type' => ['required', 'string', Rule::in([UserTypeEnum::BUSINESS->value])],
      'fullname' => ['required', 'string', 'max:50'],
      'id_type' => ['required', 'string'],
      'id_number' => ['required', 'numeric'],
      'birth_country' => ['required'],
      'citizenship_country' => ['required'],
      'state' => ['required', 'string'],
      'expiry_date' => ['required', 'string'],
      'dob' => ['required', 'string'],
      'address' => ['nullable', 'string'],
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
      'dob.required' => 'Date of birth is required',
      'type.required' => 'Type can be either individual or business',
    ];
  }
}






