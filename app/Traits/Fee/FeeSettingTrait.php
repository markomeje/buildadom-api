<?php

namespace App\Traits\Fee;
use App\Enums\Fee\FeeTypeEnum;
use App\Models\Fee\FeeSetting;
use Exception;

trait FeeSettingTrait
{
    /**
     * @param string $fee_code
     * @return string
     */
    public function convertToReadable(string $fee_code)
    {
        $code = strtolower($fee_code);
        if(str_contains($code, '_')) {
            $parts = explode('_', $code);
            $code = ucwords(implode(' ', $parts));
        }else {
            $code = strtoupper($code);
        }

        return $code;
    }

    /**
     * @param string $code
     * @param float|int $amount
     * @throws Exception
     * @return int
     */
    public function calculateFeeAmount(string $code, float|int $amount)
    {
        $fee = FeeSetting::where('code', $code)->first();
        if(empty($fee)) {
            throw new Exception('Invalid fee setting.');
        }

        $fee_amount = (float)$fee->amount;
        if(strtolower($fee->type) == strtolower(FeeTypeEnum::PERCENTAGE_FEE->value)) {
            $fee_amount = ($fee_amount / 100) * $amount;
        }

        return (int)$fee_amount;
    }


}
