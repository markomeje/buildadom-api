<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Get all products
   * @param json
   */
  public function products()
  {
    $products = Category::with(['products'])->where(['type' => 'product'])->inRandomOrder()->get()->map(function ($query) {
      $query->setRelation('products', $query->products->take(6));
      return $query;
    });

    return response()->json([
      'success' => true,
      'message' => 'Countries retrieved successfully',
      'products' => $products,
    ], 200);
  }
}
