<?php

namespace App\Http\Controllers\V1\Marchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Services\StoreService;
use App\Models\Store;
use \Exception;


class StoreController extends Controller
{

  /**
   * Store
   * @param $request, StoreService
   */
  public function create(StoreRequest $request)
  {
    try {
      $store = (new StoreService())->create($request->validated());
      return response()->json([
        'success' => true,
        'message' => 'Store created successfully',
        'store' => $store,
      ], 201);
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
      if($store = Store::where(['id' => $id, 'user_id' => auth()->id()])->first()) {
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

  /**
   * Update Store
   * @param StoreService $request, $id
   */
  public function update($id, StoreRequest $request)
  {
    try {
      $store = (new StoreService())->update($request->validated(), $id);
      return response()->json([
        'success' => true,
        'message' => 'Store updated successfully',
        'store' => $store,
      ], 201);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}


