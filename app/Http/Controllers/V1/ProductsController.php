<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use App\Http\Resources\{CategoryResource, ProductResource};
use \Exception;


class ProductsController extends Controller
{

  /**
   * Get a all Products
   * @param $limit
   */
  public function index()
  {
    try {
      $limit = request()->get('limit') ?? 24;
      $category = request()->get('category') ?? 0;
      $products = empty($category) ? Product::with(['images'])->paginate($limit) : Product::with(['images'])->where(['category_id' => $category])->paginate($limit);

      if (empty($products->count())) {
        return response()->json([
          'success' => true,
          'message' => 'No products available',
          'products' => [],
        ], 200);
      }

      return response()->json([
        'success' => true,
        'message' => 'Products retrieved successfully',
        'products' => ProductResource::collection($products),
      ], 200);
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
      if($product = Product::find($id)) {
        $attributes = $product->attributes;
        $product->attributes = empty($attributes) ? null : explode('|', $attributes);
        return response()->json([
          'success' => true,
          'message' => 'Product retrieved successfully',
          'product' => $product,
        ], 200);
      }

      return response()->json([
        'success' => false,
        'message' => 'Product not found. Try again.',
      ], 404);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get all Product categories
   */
  public function categories()
  {
    try {
      $categories = Category::where(['type' => 'product'])->get();
      return response()->json([
        'success' => true,
        'message' => 'Product categories retrieved successfully',
        'categories' => CategoryResource::collection($categories),
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}


