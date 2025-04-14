<?php

declare(strict_types=1);

namespace App\Services\V1\Product;
use App\Models\Product\ProductCategory;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductCategoryService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $categories = ProductCategory::latest()->get();

            return responser()->send(Status::HTTP_OK, $categories, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }
}
