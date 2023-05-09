<?php

namespace App\Http\Controllers\V1\Marchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Models\{Product, Category};
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
      if($product = Product::with(['images', 'category', 'currency'])->where(['id' => $id, 'user_id' => auth()->id()])->first()) {
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
   * Update Product
   * @param ProductService $request, $id
   */
  public function update($id, ProductRequest $request)
  {
    try {
      if($product = (new ProductService())->update($id, $request->validated())) {
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

  /**
   * Publish Product
   * @param $id
   */
  public function publish($id = 0)
  {
    try {
      $product = ProductService::where(['user_id' => auth()->id()], $id);
      if (empty($product)) {
        return response()->json([
          'success' => false,
          'message' => 'Product not found. Try again.',
          $product
        ], 404);
      }

      if (empty($product->images) || $product->images()->count() < 1) {
        return response()->json([
          'success' => false,
          'message' => 'Please upload a product image inorder to publish.',
        ], 401);
      }

      if((new ProductService())->update($id, ['published' => request()->post('published') ?? false])) {
        return response()->json([
          'success' => true,
          'message' => 'Operation successful',
          'product' => $product,
        ], 200);
      }

      return response()->json([
        'success' => false,
        'message' => 'Product publishing failed. Try again.',
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get a all marchant Product
   */
  public function products()
  {
    try {
      $products = Product::with(['images', 'category', 'currency'])->where(['user_id' => auth()->id()])->latest()->paginate(request()->get('limit') ?? 20)->groupBy(function($product) {
        return $product->category->name;
      });

      return response()->json([
        'success' => true,
        'message' => 'Products retrieved successfully',
        'products' => $products,
      ], 200);
    } catch (Exception $error) {
      return response()->json([
       'success' => false,
       'message' => $error->getMessage(),
      ], 500);
    }
  }

}


