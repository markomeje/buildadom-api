<?php

namespace App\Services\V1\Document;
use App\Models\Document\DocumentType;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;

class DocumentTypeService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $documents = DocumentType::latest()->get();

            return responser()->send(Status::HTTP_OK, $documents, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }
}
