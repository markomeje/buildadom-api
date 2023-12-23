<?php

namespace App\Http\Controllers\V1\Merchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Services\DriverService;
use App\Models\Driver;
use \Exception;


class DriverController extends Controller
{

  /**
   * add Driver
   * @param $request, DriverService
   */
  public function add(DriverRequest $request)
  {
    try {
      if($driver = (new DriverService())->add($request->validated())) {
        return response()->json([
          'success' => true,
          'message' => 'Driver created successfully',
          'driver' => $driver,
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
   * Get all Drivers
   */
  public function drivers()
  {
    try {
      if($drivers = Driver::where(['user_id' => auth()->id()])->get()) {
        return response()->json([
          'success' => true,
          'message' => 'Driver retrieved successfully',
          'drivers' => $drivers,
        ], 200);
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
   * Update Driver
   * @param DriverService $request, $id
   */
  public function update($id, DriverRequest $request)
  {
    try {
      if($driver = (new DriverService())->update($request->validated(), $id)) {
        return response()->json([
          'success' => true,
          'message' => 'Driver updated successfully',
          'driver' => $driver,
        ], 200);
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
   * Delete a Driver
   */
  public function delete(int $id = 0)
  {
    try {
      if($driver = Driver::find($id)) {
        $driver->delete();
        return response()->json([
          'success' => true,
          'message' => 'Driver deleted successfully',
          'drivers' => Driver::where(['user_id' => auth()->id()])->get(),
        ], 200);
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

}
