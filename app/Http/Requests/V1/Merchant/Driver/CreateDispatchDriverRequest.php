<?php

namespace App\Http\Requests\V1\Merchant\Driver;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateDispatchDriverRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'phone'],
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
            'phone.phone' => 'Invalid phone number',
        ];
    }

    /**
     * Customize failed validation json response
     *
     *
     * @param Validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $response = responser()->send(Status::HTTP_UNPROCESSABLE_ENTITY, [
            'errors' => $validator->errors(),
        ], 'Please check your inputs.');

        throw new ValidationException($validator, $response);
    }
}
