<?php

namespace App\Services\V1\Product;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductService extends BaseService
{

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $query = Product::query()->latest()->published();
      if($request->query('category')) {
        $query->where('product_category_id', (int)$request->category);
      }

      $products = $query->with(['unit', 'images', 'category', 'store', 'currency'])->paginate($request->limit ?? 20);
      return responser()->send(Status::HTTP_OK, ProductResource::collection($products), 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @param int $id
   * @return JsonResponse
   */
  public function show($id): JsonResponse
  {
    try {
      $product = Product::published()->with(['images', 'unit', 'category', 'store'])->find($id);
      return responser()->send(Status::HTTP_OK, $product, 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
