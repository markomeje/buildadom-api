<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Store};
use App\Http\Resources\{CategoryResource, ProductResource};
use Exception;


class ProductsController extends Controller
{

  /**
   * Get a all Products
   */
  public function index()
  {
    try {
      $products = Product::with(['images', 'category'])->latest()->inRandomOrder()->published()->paginate(request()->get('limit') ?? 24);
      return response()->json([
        'success' => true,
        'message' => $products->count() > 0 ? 'Products retrieved successfully' : 'No published products available',
        'products' => $products,
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get Products by category
   */
  public function category($category_id = 0)
  {
    try {
      $products = Product::with(['images', 'category'])->latest()->where(['category_id' => $category_id])->published()->paginate(request()->get('limit') ?? 24);

      return response()->json([
        'success' => true,
        'message' => empty($products->count()) ? 'No published products available' : 'Products retrieved successfully',
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
      if($product = Product::with(['images', 'currency', 'category'])->where(['id' => $id])->first()) {
        $attributes = $product->attributes;
        $product->attributes = empty($attributes) ? [] : explode('|', $attributes);
        return response()->json([
          'success' => true,
          'message' => 'Product retrieved successfully',
          'product' => $product,
        ], 200);
      }

      return response()->json([
        'success' => false,
        'message' => 'Product not found. Try again.',
      ], 200);
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


