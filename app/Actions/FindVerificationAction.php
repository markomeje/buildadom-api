<?php

namespace App\Actions;
use App\Models\Verification;


class FindVerificationAction
{
  /**
   * Handle Verification check
   *
   * @return Onboarding model
   * @param array $data
   */
  public static function handle(array $data): Verification
  {
    $verification = Verification::where([...$data])->first();
    return $verification;
  }
}
