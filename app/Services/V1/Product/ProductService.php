<?php

namespace App\Services\V1\Product;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Services\BaseService;
use App\Traits\ProductTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductService extends BaseService
{
  use ProductTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $limit = $request->limit ?? 20;
      $products = Product::published()->with($this->loadProductRelations())->latest()->paginate($limit);
      return Responser::send(Status::HTTP_OK, ProductResource::collection($products), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
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
      return Responser::send(Status::HTTP_OK, $product, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
