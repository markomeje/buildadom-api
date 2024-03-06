<?php

namespace App\Services\V1\Merchant\Product;
use App\Models\Product\Product;
use App\Services\BaseService;
use App\Utility\Responser;
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

      return Responser::send(JsonResponse::HTTP_OK, $product, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * Update product
   *
   * @param array $data int $id
   */
  public function update(int $id, array $data)
  {
    return Product::findOrFail($id)->update($data);
  }

  /**
   * Get Product
   * @param array $data, int $id
   */
  public static function where(array $data, $id)
  {
    return Product::with(['images', 'category'])->where([
      ...$data,
      'id' => $id
    ])->first();
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function edit($id, Request $request): JsonResponse
  {
    try {
      $product = Product::query()->find($id);
      if(empty($product)) {
        return Responser::send(JsonResponse::HTTP_NOT_FOUND, $product, 'Product record not found. Try again.');
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

      return Responser::send(JsonResponse::HTTP_OK, $product, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }
}
