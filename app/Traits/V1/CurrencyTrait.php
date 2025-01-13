<?php

namespace App\Traits\V1;
use App\Models\Currency;
use Exception;

trait CurrencyTrait
{
  /**
   * @throws Exception
   * @return Currency
   */
  public function getDefaultCurrency()
  {
    $currency = Currency::isSupported()->isDefault()->first();
    if(empty($currency)) {
      throw new Exception('Default supported currency not set.');
    }

    return $currency;
  }

  /**
   * @param float $amount
   * @return string
   */
  public function formatCurrencyAmount(float $amount): string
  {
    return $this->getDefaultCurrency()->code.number_format($amount);
  }

}