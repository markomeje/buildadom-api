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
      $identifications = Identification::paginate(12);
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

}


