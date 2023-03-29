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
      return response()->json([
        'success' => false,
        'message' => 'Products retrieved successfully',
        'products' => ProductResource::collection(Product::with(['images'])->paginate($limit)),
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
      return response()->json([
        'success' => true,
        'message' => 'Product categories retrieved successfully',
        'categories' => CategoryResource::collection(Category::where(['type' => 'product'])->get()),
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}


