<?php

namespace App\Http\Controllers\V1\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Upload\UploadRequest;
use App\Services\V1\Upload\UploadService;
use Illuminate\Http\JsonResponse;


class UploadController extends Controller
{
  /**
   * @param UploadService $upload
   */
  public function __construct(public UploadService $upload)
  {
    $this->upload = $upload;
  }

  /**
   * @param UploadRequest $request
   * @return JsonResponse
   */
  public function handle($id = null, UploadRequest $request): JsonResponse
  {
    return $this->upload->handle($id, $request);
  }

}
