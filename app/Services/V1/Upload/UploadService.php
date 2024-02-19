<?php

namespace App\Services\V1\Upload;
use App\Actions\UploadImageAction;
use App\Models\Store\Store;
use App\Models\Upload\Upload;
use App\Services\BaseService;
use App\Utility\Responser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UploadService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function handle($id = null, Request $request): JsonResponse
  {
    try {
      $file = $request->file('upload');
      $upload = Upload::find($id);

      if(empty($upload)) {
        $uploaded = UploadImageAction::handle($file);
        $upload = Upload::create([
          'url' => $uploaded['url'],
          'user_id' => auth()->id(),
          'role' => $request->role,
          'filename' => $uploaded['filename'],
          'name' => $request->name,
        ]);

        return Responser::send(JsonResponse::HTTP_OK, $upload, 'File updated successfully.');
      }

      $uploaded = UploadImageAction::handle($file, $upload->filename);
      $upload = $upload->update([
        'url' => $uploaded['url'],
        'name' => $request->name,
        'role' => $request->role,
        'filename' => $uploaded['filename'],
      ]);

      return Responser::send(JsonResponse::HTTP_OK, $upload, 'File uploaded successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}
