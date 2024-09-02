<?php

namespace App\Http\Controllers\V1\Merchant\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Product\CreateProductRequest;
use App\Http\Requests\V1\Merchant\Product\UpdateProductRequest;
use App\Services\V1\Merchant\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
  /**
   * @param ProductService $productService
   */
  public function __construct(public ProductService $productService)
  {
    $this->productService = $productService;
  }

  /**
   * @param CreateProductRequest $request
   * @return JsonResponse
   */
  public function add(CreateProductRequest $request): JsonResponse
  {
    return $this->productService->add($request);
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
   * @param UpdateProductRequest $request
   * @return JsonResponse
   */
  public function update($id, UpdateProductRequest $request): JsonResponse
  {
    return $this->productService->update($id, $request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function product($id, Request $request): JsonResponse
  {
    return $this->productService->product($id, $request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function publish($id, Request $request): JsonResponse
  {
    return $this->productService->publish($id, $request);
  }

}
