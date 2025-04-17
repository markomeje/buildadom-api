<?php

namespace App\Http\Controllers\V1\Product;
use App\Http\Controllers\Controller;
use App\Services\V1\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function list(Request $request): JsonResponse
    {
        return $this->productService->list($request);
    }

    /**
     * @param  int  $id
     */
    public function show($id): JsonResponse
    {
        return $this->productService->show($id);
    }

    public function search(Request $request): JsonResponse
    {
        return $this->productService->search($request);
    }

    public function filter(Request $request): JsonResponse
    {
        return $this->productService->filter($request);
    }
}
