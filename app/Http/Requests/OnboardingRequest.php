<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\EmailRule;

class OnboardingRequest extends FormRequest
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
        return [
            'email' => ['required', 'email', 'unique:onboardings', (new EmailRule)],
            'phone' => ['required', 'unique:onboardings'],
            'firstname' => ['required', 'string', 'max:50'],
            'business_name' => [strtolower($this->type) === 'individual' ? 'nullable' : 'required', 'max:255'],
            
            'lastname' => ['required', 'string', 'max:50'],
            'location' => ['required', 'max:255'],
            'materials' => ['required', 'max:500'],
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
            'materials.required' => 'Please list the kinds of materials you sell.',
        ];
    }
}














