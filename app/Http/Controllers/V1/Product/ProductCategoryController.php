<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Product;
use App\Http\Controllers\Controller;
use App\Services\V1\Product\ProductCategoryService;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    public function __construct(private ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    public function list(): JsonResponse
    {
        return $this->productCategoryService->list();
    }
}
