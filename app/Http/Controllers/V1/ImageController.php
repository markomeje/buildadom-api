<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveImageRequest;
use App\Actions\ImageAction;
use App\Models\{Image, Store, Identification};
use Storage;
use Exception;

class ImageController extends Controller
{
  /**
   * Save image file to s3
   *
   * @param json
   */
  public function upload(SaveImageRequest $request)
  {
    try {
      $model_id = $request->model_id;
      switch ($request->model) {
        case 'store':
          $result = Store::find($model_id);
          break;
        case 'identification':
          $result = Identification::find($model_id);
          break;

        default:
          return response()->json([
            'success' => false,
            'message' => 'Invalid upload model',
          ], 500);
          break;
      }

      if (empty($result) || !$request->hasfile('image')) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid upload request',
        ], 500);
      }


      if($image = (new ImageAction())->handle($request->validated())) {
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












