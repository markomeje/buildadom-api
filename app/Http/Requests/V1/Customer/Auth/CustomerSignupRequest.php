<?php

namespace App\Http\Requests\V1\Customer\Auth;
use App\Rules\EmailRule;
use App\Rules\PasswordRule;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CustomerSignupRequest extends FormRequest
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
            'email' => ['required', 'unique:users', (new EmailRule)],
            'password' => ['required', (new PasswordRule)],
            'confirm_password' => ['required', 'same:password'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', Rule::unique('users'), 'phone'],
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
            'phone.phone' => 'Invalid phone number'
        ];
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
        $response = responser()->send(Status::HTTP_UNPROCESSABLE_ENTITY, [
            'errors' => $validator->errors()
        ], 'Please check your inputs.');

        throw new ValidationException($validator, $response);
    }
}
