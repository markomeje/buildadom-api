<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
      'firstname' => ['required', 'string', 'max:255'],
      'lastname' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'phone', Rule::unique('drivers')->ignore($this->request->id)],
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
      'phone.phone' => 'Invalid phone number. Please include country code and try again.'
    ];
  }
}
