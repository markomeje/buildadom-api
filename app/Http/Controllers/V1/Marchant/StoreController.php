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
      $identification = auth()->user()->identification;
      if ((boolean)($identification->verified ?? false) !== true) {
        return response()->json([
          'success' => false,
          'message' => empty($identification) ? 'Please start your ID verification' : 'Please your ID is not verified yet.',
        ], 403);
      }

      if($store = (new StoreService())->create($request->validated())) {
        return response()->json([
          'success' => true,
          'message' => 'Store created successfully',
          'store' => $store,
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
   * Get a Marchant Store
   * @param $id
   */
  public function store()
  {
    try {
      if($store = Store::with(['images'])->where(['user_id' => auth()->id()])->first()) {
        return response()->json([
          'success' => true,
          'message' => 'Store retrieved successfully',
          'store' => $store,
        ], 201);
      }

      return response()->json([
       'success' => false,
       'message' => 'No store yet. Create one.',
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
   * @param StoreRequest $request, $id
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


