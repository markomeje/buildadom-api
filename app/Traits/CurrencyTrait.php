<?php

namespace App\Traits;
use App\Models\Currency;
use Exception;

trait CurrencyTrait
{
  /**
   * @return null|Currency
   */
  public function getDefaultCurrency()
  {
    $currency = Currency::isSupported()->where('is_default', 1)->first();
    if(empty($currency)) {
      throw new Exception('No default supported currency set.');
    }

    return $currency;
  }

}