<?php

declare(strict_types=1);

namespace App\Traits;
use App\Models\Currency;
use Exception;

trait CurrencyTrait
{
    /**
     * @return Currency
     *
     * @throws Exception
     */
    public function getDefaultCurrency()
    {
        $currency = Currency::isSupported()->isDefault()->first();
        if (empty($currency)) {
            throw new Exception('Default supported currency not set.');
        }

        return $currency;
    }

    public function formatCurrencyAmount(float $amount): string
    {
        return $this->getDefaultCurrency()->code . number_format($amount);
    }
}
