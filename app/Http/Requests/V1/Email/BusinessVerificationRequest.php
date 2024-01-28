<?php

namespace App\Http\Requests\V1\Kyc;
use App\Enums\DocumentTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class SaveKycVerificationRequest extends FormRequest
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
      'fullname' => ['required', 'string', 'max:50'],
      'id_type' => ['required', 'string', new Enum(DocumentTypeEnum::class)],
      'id_number' => ['required', 'string'],
      'birth_country' => ['required', 'int', Rule::exists('countries', 'id')],
      'citizenship_country' => ['required', 'int', Rule::exists('countries', 'id')],
      'state' => ['required', 'string', 'max:50'],
      'expiry_date' => ['required', 'string', 'date'],
      'birth_date' => ['required', 'string', 'date'],
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
    ];
  }
}






