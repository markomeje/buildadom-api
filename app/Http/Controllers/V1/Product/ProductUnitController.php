<?php

namespace App\Http\Controllers\V1\Product;
use App\Http\Controllers\Controller;
use App\Services\V1\Product\ProductUnitService;
use Illuminate\Http\JsonResponse;

class ProductUnitController extends Controller
{
    public function __construct(private ProductUnitService $productUnitService)
    {
        $this->productUnitService = $productUnitService;
    }

    public function list(): JsonResponse
    {
        return $this->productUnitService->list();
    }
}
