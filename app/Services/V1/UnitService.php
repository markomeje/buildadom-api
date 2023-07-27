<?php


namespace App\Services\V1;
use Exception;
use App\Models\Unit;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;


class UnitService extends BaseService
{
  /**
   * @param Unit $unit
   */
  public function __construct(public Unit $unit)
  {
    $this->unit = $unit;
  }

  /**
   * @return JsonResponse
   */
  public function units(): JsonResponse
  {
    try {
      $units = $this->unit->all();
      return $this->successResponse(['units' => $units]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}












