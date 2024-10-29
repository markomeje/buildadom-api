<?php

namespace App\Http\Controllers\V1\Product;
use App\Http\Controllers\Controller;
use App\Services\V1\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  /**
   * @param ProductService $productService
   */
  public function __construct(private ProductService $productService)
  {
    $this->productService = $productService;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->productService->list($request);
  }

  /**
   * @param int $id
   * @return JsonResponse
   */
  public function show($id): JsonResponse
  {
    return $this->productService->show($id);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function search(Request $request): JsonResponse
  {
    return $this->productService->search($request);
  }

}
