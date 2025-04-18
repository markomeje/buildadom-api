<?php

namespace App\Services\V1\Merchant\Product;
use App\Models\Product\Product;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductService extends BaseService
{
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

            return responser()->send(Status::HTTP_OK, $product, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage(), $e);
        }
    }

    public function list(Request $request)
    {
        try {
            $products = Product::owner()->latest()->with([
                'currency' => function ($query) {
                    return $query->select(['id', 'name', 'code']);
                },
                'unit' => function ($query) {
                    return $query->select(['id', 'name']);
                },
                'category',
                'images',
                'store',
            ])->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, $products, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }

    public function publish($id, Request $request)
    {
        try {
            $product = Product::owner()->with(['images'])->find($id);
            if (empty($product)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Product record not found. Try again.');
            }

            if (!$product->images()->exists()) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Upload at least one product picture.');
            }

            $product->update(['published' => (bool) $request->published]);

            return responser()->send(Status::HTTP_OK, $product, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }

    public function product($id, Request $request)
    {
        try {
            $product = Product::owner()->with([
                'currency' => function ($query) {
                    return $query->select(['id', 'name', 'code']);
                },
                'unit' => function ($query) {
                    return $query->select(['id', 'name']);
                },
                'category',
                'images',
                'store',
            ])->find($id);

            if (empty($product)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Product record not found. Try again.');
            }

            return responser()->send(Status::HTTP_OK, $product, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }

    /**
     * @param  int  $id
     */
    public function update($id, Request $request): JsonResponse
    {
        try {
            $product = Product::owner()->with(['images'])->find($id);
            if (empty($product)) {
                return responser()->send(Status::HTTP_NOT_FOUND, $product, 'Product record not found. Try again.');
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

            return responser()->send(Status::HTTP_OK, $product, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }
}
