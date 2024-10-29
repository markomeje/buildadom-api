<?php

namespace App\Services\V1\Product;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Services\BaseService;
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
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
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
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function search(Request $request): JsonResponse
  {
    try {
      $search = $request->get('query');
      $products = Product::with('store')->published()
        ->where(function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('tags', 'LIKE', "%{$search}%");
        })
        ->get();
      return responser()->send(Status::HTTP_OK, ProductResource::collection($products), 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function filter(Request $request): JsonResponse
  {
    try {
      $product_category = $request->get('product_category');
      $product_unit = $request->get('product_unit');
      $min_price = $request->get('min_price');
      $max_price = $request->get('max_price');
      $product_store = $request->get('product_store');

      $products = Product::query()->with(['store', 'category'])->published()
        ->where(function ($query) use ($product_unit, $product_category, $min_price, $max_price, $product_store) {
          $query->when($product_unit, function ($query) use ($product_unit) {
            return $query->orWhere('product_unit_id', $product_unit);
          })->when($product_category, function ($query) use ($product_category) {
            return $query->orWhere('product_category_id', $product_category);
          })->when($min_price, function ($query) use ($min_price) {
            return $query->orWhere('price', '>=', $min_price);
          })->when($max_price, function ($query) use ($max_price) {
            return $query->orWhere('price', '<=', $max_price);
          })->when($product_store, function ($query) use ($product_store) {
            return $query->orWhere('store_id', $product_store);
          });
        })->get();

      return responser()->send(Status::HTTP_OK, ProductResource::collection($products), 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

}
