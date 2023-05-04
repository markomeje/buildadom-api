<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Rules\EmailRule;
use App\Models\{User};

class MarchantSignupRequest extends FormRequest
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
      $business = strtolower($this->type ?? null) === 'business';
      return [
         'type' => ['required', 'string'],
         'email' => ['required', 'email', 'unique:users', (new EmailRule)],
         'phone' => ['required', 'unique:users', 'phone'],
         'firstname' => [!$business ? 'required' : 'nullable', 'string', 'max:50'],
         'lastname' => [!$business ? 'required' : 'nullable', 'string', 'max:50'],

         'business_name' => [$business ? 'required' : 'nullable', 'max:255'],
         'cac_number' => [$business ? 'required' : 'nullable', 'max:20'],
         'website' => ['nullable', 'max:255'],
         
         'address' => ['required', 'max:255'],
         'password' => ['required', app()->environment(['production']) ? Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised() : 'min:8'],
         'confirm_password' => ['required', 'same:password']
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
         'cac_number.required' => 'Please enter your CAC registration number.',
         'phone.phone' => 'Invalid phone number. Please include country code and try again.'
      ];
   }
}














