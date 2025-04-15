<?php

namespace App\Http\Requests\V1\Kyc;
use App\Enums\Kyc\KycFileSideEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ChangeKycFileRequest extends FormRequest
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
            'file_side' => ['required', 'string', new Enum(KycFileSideEnum::class)],
            'kyc_verification_id' => ['required', 'int', Rule::exists('kyc_verifications', 'id')],
            'kyc_file' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5048'],
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
        $response = responser()->send(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [
            'errors' => $validator->errors(),
        ], 'Please check your inputs.');

        throw new ValidationException($validator, $response);
    }
}
