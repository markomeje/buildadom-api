<?php

namespace App\Http\Requests\V1\Merchant\Bank;
use App\Utility\Status;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateBankAccountRequest extends FormRequest
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
            'account_name' => ['nullable', 'max:50'],
            'account_number' => ['required', 'max:50'],
            'bank_id' => ['required', Rule::exists('nigerian_banks', 'id')],
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
