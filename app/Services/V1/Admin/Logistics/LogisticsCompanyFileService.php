<?php

namespace App\Services\V1\Admin\Logistics;
use App\Services\BaseService;
use App\Traits\CurrencyTrait;
use App\Traits\FileUploadTrait;
use App\Utility\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogisticsCompanyFileService extends BaseService
{
    use CurrencyTrait;
    use FileUploadTrait;

    public function create(Request $request): JsonResponse
    {
        return responser()->send(Status::HTTP_OK, $request->all(), '');
    }
}
