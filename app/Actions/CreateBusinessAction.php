<?php

namespace App\Actions;
use App\Models\Business;
use Propaganistas\LaravelPhone\PhoneNumber;


class CreateBusinessAction
{
  /**
   * Handle Business request
   *
   * @return Business model
   */
  public static function handle(array $data): Business
  {
    return Business::create([...$data]);
  }
}
