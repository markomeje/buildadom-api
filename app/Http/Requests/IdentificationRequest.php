<?php

namespace App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Identification;

class IdentificationRequest extends FormRequest
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
    $now = Carbon::now()->format('d/m/Y');
    return [
      'id_type' => ['required', 'string'],
      'id_number' => ['required', 'numeric'],
      'expiry_date' => ['required', 'date_format:d/m/Y', "after:{$now}"],
      'dob' => ['required', 'date_format:d/m/Y', 'after:01/01/1940'],
      'address' => ['required', 'string'],
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
      'dob.after' => 'Date of birth must be date after 01/01/1940',
    ];
  }
}






