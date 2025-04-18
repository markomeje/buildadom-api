<?php

namespace App\Http\Controllers\V1\Merchant\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Product\ChangeProductImageRequest;
use App\Http\Requests\V1\Merchant\Product\DeleteProductImageRequest;
use App\Http\Requests\V1\Merchant\Product\UploadProductImageRequest;
use App\Services\V1\Merchant\Product\ProductImageService;
use Illuminate\Http\JsonResponse;

class ProductImageController extends Controller
{
    public function __construct(public ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    public function upload(UploadProductImageRequest $request): JsonResponse
    {
        return $this->productImageService->upload($request);
    }

    /**
     * @param  int  $id
     */
    public function delete($id, DeleteProductImageRequest $request): JsonResponse
    {
        return $this->productImageService->delete($id, $request);
    }

    /**
     * @param  int  $id
     */
    public function change($id, ChangeProductImageRequest $request): JsonResponse
    {
        return $this->productImageService->change($id, $request);
    }
}
