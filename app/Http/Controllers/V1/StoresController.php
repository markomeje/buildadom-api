<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use \Exception;


class StoresController extends Controller
{

  /**
   * Get a all Stores
   * @param $limit
   */
  public function index()
  {
    try {
      $stores = Store::published()->with(['images', 'products'])->latest()->inRandomOrder()->paginate(request()->get('limit') ?? 12);
      return response()->json([
        'success' => true,
        'message' => $stores->count() > 0 ? 'Stores retrieved successfully' : 'No published stores available',
        'stores' => $stores,
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get a single Store
   * @param $id
   */
  public function store($id = 0)
  {
    try {
      if($store = Store::with(['images', 'products'])->find($id)) {
        return response()->json([
          'success' => true,
          'message' => 'Store retrieved successfully',
          'store' => $store,
        ], 201);
      }

      return response()->json([
        'success' => false,
        'message' => 'Store not found',
      ], 404);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }
}


