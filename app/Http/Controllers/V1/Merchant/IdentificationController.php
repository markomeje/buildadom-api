<?php

namespace App\Http\Controllers\V1\Merchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdentificationRequest;
use App\Services\{IdentificationService, ImageRequest};
use App\Models\Identification;
use Exception;


class IdentificationController extends Controller
{

  /**
   * Identification
   * @param $request, IdentificationService
   */
  public function save(IdentificationRequest $request)
  {
    try {
      if (!in_array($request->type, ['individual', 'business'])) {
        throw new Exception('Invalid identification type. Type must be either individual or business.');
      }

      if (strtolower(auth()->user()->type) === 'business' && strtolower($request->type) !== 'business') {
        return response()->json([
          'success' => false,
          'message' => 'User type and ID type must be both same.',
        ], 403);
      }

      $identification = (new IdentificationService())->save($request->validated());
      return response()->json([
        'success' => true,
        'message' => 'Identification saved successfully',
        'identification' => $identification,
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Identification types
   */
  public function types()
  {
    return response()->json([
      'success' => true,
      'message' => 'All identification types',
      'types' => Identification::$types,
    ], 200);
  }

  /**
   * Identification types
   */
   public function details()
   {
      try {
        $identification = IdentificationService::details();
        return response()->json([
          'success' => true,
          'message' => 'Operation successful',
          'details' => $identification,
        ], 200);
      } catch (Exception $error) {
        return response()->json([
         'success' => false,
         'message' => $error->getMessage(),
        ], 500);
      }
   }


}


