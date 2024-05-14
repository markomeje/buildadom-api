<?php

namespace App\Http\Controllers\V1\Document;
use App\Http\Controllers\Controller;
use App\Services\V1\Document\DocumentTypeService;
use Illuminate\Http\JsonResponse;

class DocumentTypeController extends Controller
{
  /**
   * @param DocumentTypeService $documentTypeService
   */
  public function __construct(private DocumentTypeService $documentTypeService)
  {
    $this->documentTypeService = $documentTypeService;
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    return $this->documentTypeService->list();
  }

}
