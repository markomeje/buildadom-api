<?php

namespace App\Http\Controllers\V1\Marchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Models\Product;
use \Exception;


class ProductController extends Controller
{

  /**
   * Product
   * @param $request, ProductService
   */
  public function create(ProductRequest $request)
  {
    try {
      if($product = (new ProductService())->create($request->validated())) {
        return response()->json([
          'success' => true,
          'message' => 'Product created successfully',
          'product' => $product,
        ], 201);
      }

      return response()->json([
        'success' => false,
        'message' => 'Operation failed. Try again.',
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get a single Product
   * @param $id
   */
  public function product($id = 0)
  {
    try {
      if($product = Product::with(['images'])->where(['id' => $id])->first()) {
        return response()->json([
          'success' => true,
          'message' => 'Product retrieved successfully',
          'product' => $product,
        ], 201);
      }

      return response()->json([
        'success' => false,
        'message' => 'Product not found',
      ], 404);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Update Product
   * @param ProductService $request, $id
   */
  public function update($id, ProductRequest $request)
  {
    try {
      if($product = (new ProductService())->update($request->validated(), $id)) {
        return response()->json([
          'success' => true,
          'message' => 'Product updated successfully',
          'product' => $product,
        ], 200);
      }

      return response()->json([
        'success' => true,
        'message' => 'Operation failed. Try again.',
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}


