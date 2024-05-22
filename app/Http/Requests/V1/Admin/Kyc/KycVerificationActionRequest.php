<?php

namespace App\Http\Requests\V1\Admin\Kyc;
use App\Enums\Kyc\KycVerificationStatusEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class KycVerificationActionRequest extends FormRequest
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
      'status' => ['required', 'string', new Enum(KycVerificationStatusEnum::class)],
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
}
