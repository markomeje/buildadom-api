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
    public function __construct(public ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function add(CreateProductRequest $request): JsonResponse
    {
        return $this->productService->add($request);
    }

    public function list(Request $request): JsonResponse
    {
        return $this->productService->list($request);
    }

    public function update($id, UpdateProductRequest $request): JsonResponse
    {
        return $this->productService->update($id, $request);
    }

    public function product($id, Request $request): JsonResponse
    {
        return $this->productService->product($id, $request);
    }

    public function publish($id, Request $request): JsonResponse
    {
        return $this->productService->publish($id, $request);
    }
}
