<?php

namespace App\Http\Controllers\V1\Product;
use App\Http\Controllers\Controller;
use App\Services\V1\Product\ProductCategoryService;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
  /**
   * @param ProductCategoryService $productCategoryService
   */
  public function __construct(private ProductCategoryService $productCategoryService)
  {
    $this->productCategoryService = $productCategoryService;
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    return $this->productCategoryService->list();
  }
}
