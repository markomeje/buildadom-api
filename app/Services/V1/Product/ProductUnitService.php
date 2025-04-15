<?php

namespace App\Services\V1\Product;
use App\Models\Product\ProductUnit;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductUnitService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $units = ProductUnit::latest()->get();

            return responser()->send(Status::HTTP_OK, $units, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }
}
