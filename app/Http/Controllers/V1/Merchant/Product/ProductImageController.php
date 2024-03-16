<?php

namespace App\Http\Controllers\V1\Merchant\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Product\ChangeProductImageRequest;
use App\Http\Requests\V1\Merchant\Product\UploadProductImageRequest;
use App\Services\V1\Merchant\Product\ProductImageService;
use Illuminate\Http\JsonResponse;


class ProductImageController extends Controller
{
  /**
   * @param ProductImageService $productImageService
   */
  public function __construct(public ProductImageService $productImageService)
  {
    $this->productImageService = $productImageService;
  }

  /**
   * @param UploadProductImageRequest $request
   * @return JsonResponse
   */
  public function upload($product_id, UploadProductImageRequest $request): JsonResponse
  {
    return $this->productImageService->upload($product_id, $request);
  }

  /**
   * @param int $product_id
   * @return JsonResponse
   */
  public function delete($id): JsonResponse
  {
    return $this->productImageService->delete($id);
  }

  /**
   * @param ChangeProductImageRequest $request
   * @return JsonResponse
   */
  public function change($id, ChangeProductImageRequest $request): JsonResponse
  {
    return $this->productImageService->upload($id, $request);
  }

}
