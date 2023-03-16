<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ResetRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $process = strtolower($this->stage) === 'process';
        return [
            'email' => [$process ? 'required' : 'nullable', 'email', (new EmailRule)],
            'code' => [$process ? 'nullable' : 'required', 'string'],
            'stage' => ['nullable', 'string'],
            'password' => [$process ? 'nullable' : 'required', 'min:6'],
            'confirm_password' => [$process ? 'nullable' : 'required', 'min:6', 'same:password'],
            'type' => ['nullable', 'string'],
        ];
    }
}









