<?php

namespace App\Services\V1\Merchant\Product;
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
  public function add(Request $request): JsonResponse
  {
    try {
      $product = Product::create([
        'name' => $request->name,
        'currency_id' => $request->currency_id,
        'description' => $request->description,
        'quantity' => $request->quantity,
        'product_category_id' => $request->product_category_id,
        'price' => $request->price,
        'store_id' => $request->store_id,
        'user_id' => auth()->id(),
        'product_unit_id' => $request->product_unit_id,
        'tags' => $request->tags,
        'published' => false,
      ]);

      return Responser::send(Status::HTTP_OK, $product, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  public function list(Request $request)
  {
    try {
      $products = Product::owner()->latest()->with([
          'currency' => function($query) {
            return $query->select(['id', 'name', 'code']);
          },
          'unit' => function($query) {
            return $query->select(['id', 'name']);
          },
          'category',
          'images',
          'store',
        ])->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $products, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @param Request $request
   * @param int $id
   * @return JsonResponse
   */
  public function update($id, Request $request): JsonResponse
  {
    try {
      $product = Product::owner()->find($id);
      if(empty($product)) {
        return Responser::send(Status::HTTP_NOT_FOUND, $product, 'Product record not found. Try again.');
      }

      $product->update([
        'name' => $request->name,
        'currency_id' => $request->currency_id,
        'description' => $request->description,
        'quantity' => $request->quantity,
        'product_category_id' => $request->product_category_id,
        'price' => $request->price,
        'store_id' => $request->store_id,
        'product_unit_id' => $request->product_unit_id,
        'tags' => $request->tags,
      ]);

      return Responser::send(Status::HTTP_OK, $product, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }
}
