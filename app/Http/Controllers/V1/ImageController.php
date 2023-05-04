<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Actions\UploadImageAction;
use App\Models\{Image, Store, Identification, Product};
use Storage;
use Exception;

class ImageController extends Controller
{
  /**
   * Save image file to s3
   *
   * @param json
   */
  public function upload(UploadImageRequest $request)
  {
    try {
      $result = self::destination($request->model, $request->model_id);
      if (empty($result)) {
        return response()->json([
          'success' => false,
          'message' => 'Invalid upload request',
        ], 200);
      }

      if($image = UploadImageAction::handle([...$request->validated(), 'id' => $request->id])) {
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

  public static function destination(string $model = '', $model_id = 0)
  {
    switch ($model) {
      case 'store':
      $result = Store::find($model_id);
      break;

      case 'identification':
      $result = Identification::find($model_id);
      break;

      case 'product':
      $result = Product::find($model_id);
      break;

      default:
      $result = null;
      break;
    }

    return $result;
  }
}












