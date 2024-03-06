<?php

namespace App\Http\Controllers\V1\Merchant\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\V1\Merchant\Product\CreateProductRequest;
use App\Http\Requests\V1\Merchant\Product\UpdateProductRequest;
use App\Models\{Product, Category};
use App\Services\V1\Merchant\Product\ProductService;
use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{

  /**
   * Store
   * @param ProductService $product
   */
  public function __construct(public ProductService $product)
  {
    $this->product = $product;
  }

  /**
   * @param CreateProductRequest $request
   * @return JsonResponse
   */
  public function add(CreateProductRequest $request): JsonResponse
  {
    return $this->product->add($request);
  }

  /**
   * @param UpdateProductRequest $request
   * @return JsonResponse
   */
  public function update($id, UpdateProductRequest $request): JsonResponse
  {
    return $this->product->update($id, $request);
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
  public function updates($id, ProductRequest $request)
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
    } catch (\Exception $error) {
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
