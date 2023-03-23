<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Actions\ImageAction;
use App\Models\{Image, Store};
use Storage;
use Exception;

class ImageController extends Controller
{
  /**
   * Get all countries
   * @param void
   */
  public function upload(ImageRequest $request)
  {
    $model_id = $request->model_id;
    switch ($request->model) {
      case 'store':
        $found = Store::find($model_id);
        break;
  
      default:
        return response()->json([
          'success' => false,
          'message' => 'Invalid upload model',
        ], 500);
        break;
    }

    if (!$found || !$request->hasfile('image')) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid upload request',
      ], 500);
    }

    try {
      if($image = (new ImageAction())->handle($request)) {
        return response()->json([
          'success' => true,
          'message' => 'Image uploaded successfully',
          'image' => $image,
        ], 201);
      }

      throw new Exception('Uploading image failed');
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
      
  }
}












