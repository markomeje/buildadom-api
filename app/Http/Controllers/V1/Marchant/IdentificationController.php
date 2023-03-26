<?php

namespace App\Http\Controllers\V1\Marchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdentificationRequest;
use App\Services\{IdentificationService, ImageRequest};
use App\Models\Identification;
use \Exception;


class IdentificationController extends Controller
{

  /**
   * Identification
   * @param $request, IdentificationService
   */
  public function save(IdentificationRequest $request)
  {
    try {
      if (!in_array(strtolower($request->id_type), Identification::$types)) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid identification type',
        ], 406);
      }

      $identification = (new IdentificationService())->save($request->validated());
      return response()->json([
        'success' => true,
        'message' => 'Identification added successfully',
        'identification' => $identification,
      ], 201);
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
    

}


