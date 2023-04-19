<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Store;
use \Exception;


class StoreController extends Controller
{

  /**
   * Get a all Stores
   * @param $limit
   */
  public function index($limit = 12)
  {
    try {
      return response()->json([
        'success' => false,
        'message' => 'Stores retrieved successfully',
        'stores' => Store::with(['images', 'products'])->paginate($limit),
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
      if($store = Store::find($id)) {
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


