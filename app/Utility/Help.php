<?php

namespace App\Utility;
use App\Models\Country;
use Exception;

class Help
{
    /**
     * @return Country
     */
    public function getDefaultCountry()
    {
        $country = Country::where('iso2', 'NG')->first();
        if (empty($country)) {
            throw new Exception('An error occurred with default country');
        }

        return $country;
    }

    /**
     * @return string
     */
    public function generateRandomDigits(int $length = 6)
    {
        $digits = range(1, 9);
        shuffle($digits);

        return implode('', array_slice($digits, 0, $length));
    }
}
