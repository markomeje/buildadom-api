<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Document;
use App\Http\Controllers\Controller;
use App\Services\V1\Document\DocumentTypeService;
use Illuminate\Http\JsonResponse;

class DocumentTypeController extends Controller
{
    public function __construct(private DocumentTypeService $documentTypeService)
    {
        $this->documentTypeService = $documentTypeService;
    }

    public function list(): JsonResponse
    {
        return $this->documentTypeService->list();
    }
}
