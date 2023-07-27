<?php

namespace App\Http\Controllers\V1;
use Exception;
use App\Services\V1\UnitService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UnitController extends Controller
{
  /**
   * 
   */
  public function __construct(public UnitService $unit)
  {
    $this->unit = $unit;
  }

  /**
   * @return JsonResponse
   */
  public function units(): JsonResponse
  {
    return $this->unit->units();
  }
}
