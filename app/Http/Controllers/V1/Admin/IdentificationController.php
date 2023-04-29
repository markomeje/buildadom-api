<?php

namespace App\Http\Controllers\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\Identification;
use Exception;


class IdentificationController extends Controller
{

  /**
   * Identifications
   */
  public function index()
  {
    try {
      $identifications = Identification::with(['image', 'citizenship', 'birth', 'user'])->where('user_id', '<=', 25)->latest()->inRandomOrder()->paginate(request()->get('limit') ?? 45);
      return response()->json([
        'success' => true,
        'message' => 'identifications fetched successfully',
        'identifications' => $identifications,
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Verify Identification
   */
  public function verify($id = 0)
  {
    try {
      $identification = Identification::where(['id' => $id])->first();
      if (empty($identification->image)) {
        return response()->json([
          'success' => false,
          'message' => 'Identification document not uploaded yet.',
        ], 200);
      }

      $identification->verified = true;
      if($identification->update()) {
        return response()->json([
          'success' => true,
          'message' => 'Identification verified successfully',
          'identification' => $identification,
        ], 200);
      }

      return response()->json([
        'success' => true,
        'message' => 'Identification record not found',
        'identification' => null,
      ], 404);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get Single Identification
   */
  public function identification($id = 0)
  {
    try {
      if($identification = Identification::with(['image', 'citizenship', 'birth', 'user'])->where(['id' => $id])->first()) {
        return response()->json([
          'success' => true,
          'message' => 'Identification fetched successfully',
          'identification' => $identification,
        ], 200);
      }

      return response()->json([
        'success' => true,
        'message' => 'Identification record not found',
        'identification' => null,
      ], 404);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}


