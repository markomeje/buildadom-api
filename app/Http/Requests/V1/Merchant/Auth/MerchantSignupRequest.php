<?php

namespace App\Http\Requests\V1\Merchant\Auth;
use App\Enums\User\UserTypeEnum;
use App\Rules\EmailRule;
use App\Rules\PasswordRule;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class MerchantSignupRequest extends FormRequest
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
        $business = strtolower($this->type ?? '') === 'business';
        return [
            'type' => ['required', 'string', new Enum(UserTypeEnum::class)],
            'email' => ['required', 'unique:users', (new EmailRule)],
            'phone' => ['required', 'string', Rule::unique('users'), 'phone'],

            'firstname' => [!$business ? 'required' : 'nullable', 'string', 'max:50'],
            'lastname' => [!$business ? 'required' : 'nullable', 'string', 'max:50'],

            'business_name' => [$business ? 'required' : 'nullable', 'max:255'],
            'cac_number' => [$business ? 'required' : 'nullable', 'max:20'],
            'website' => ['nullable', 'max:255'],

            'address' => ['required', 'max:255'],
            'password' => ['required', (new PasswordRule)],
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
