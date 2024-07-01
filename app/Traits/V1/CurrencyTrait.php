<?php

namespace App\Traits\V1;
use App\Models\Currency;
use Exception;

trait CurrencyTrait
{
  /**
   * @return null|Currency
   */
  public function getDefaultCurrency()
  {
    $currency = Currency::isSupported()->isDefault()->first();
    if(empty($currency)) {
      throw new Exception('No default supported currency set.');
    }

    return $currency;
  }

}