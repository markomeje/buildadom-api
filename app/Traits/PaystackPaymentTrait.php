<?php

namespace App\Traits;
use Exception;

trait PaystackPaymentTrait
{
  /**
   * @param mixed $response
   * @return void
   */
  public function validateResponse($response)
  {
    if(isset($response['status']) && (boolean)$response['status'] == false) {
      throw new Exception($response['message']);
    }
  }

}
