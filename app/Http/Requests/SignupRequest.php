<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\EmailRule;
use App\Models\{User};

class SignupRequest extends FormRequest
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
     * Customize failed validation json response
     * 
     * @return void
     * 
     * @param Validator
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Please fill in all required fields.'
        ]);

        throw new ValidationException($validator, $response);
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $business = strtolower($this->type) === 'business';
        return [
            'email' => ['required', 'email', 'unique:users', (new EmailRule)],
            'phone' => ['required', 'unique:users', 'phone'],
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],

            'business_name' => [$business ? 'required' : 'nullable', 'max:255'],
            'cac_number' => [$business ? 'required' : 'nullable', 'max:20'],
            'website' => [$business ? 'required' : 'nullable', 'max:255'],
            
            'address' => ['required', 'max:255'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'min:6', 'same:password']
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
        ];
    }
}














