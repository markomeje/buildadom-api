<?php

namespace App\Services\V1\Product;
use App\Models\Product\ProductUnit;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;


class ProductUnitService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    try {
      $units = ProductUnit::latest()->get();
      return Responser::send(Status::HTTP_OK, $units, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
