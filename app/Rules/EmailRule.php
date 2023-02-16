<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EmailRule implements Rule
{
    /**
     * Adding a custom validation for email
     */
    public function passes($attribute, $value)
    {
        $validator = Validator::make([$attribute => $value], [
            $attribute => app()->environment('production') ? 'email:rfc,dns,filter' : 'email',
        ]);

        return !$validator->fails();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The email must be a valid email address.";
    }
}