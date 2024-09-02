<?php

namespace App\Http\Controllers\V1\Currency;
use App\Http\Controllers\Controller;
use App\Services\V1\Currency\CurrencyService;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
  /**
   * @param CurrencyService $currencyService
   */
  public function __construct(private CurrencyService $currencyService)
  {
    $this->currencyService = $currencyService;
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    return $this->currencyService->list();
  }

}
