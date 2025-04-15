<?php

namespace App\Http\Requests\V1\Admin\Logistics;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLogisticsCompanyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:250', Rule::unique('logistics_companies')->ignore($this->id)],
            'plate_number' => ['required', 'string', 'max:50', Rule::unique('logistics_companies')->ignore($this->id)],
            'city_id' => ['required', Rule::exists('cities', 'id')],
            'state_id' => ['required', Rule::exists('states', 'id')],
            'phone_number' => ['required', 'string'],
            'base_price' => ['required', 'gt:0'],
            'park_address' => ['required', 'string', 'max:250'],
        ];
    }
}
