<?php

namespace App\Services\V1\Admin\Logistics;
use App\Models\Country;
use App\Models\Logistics\LogisticsCompany;
use App\Services\BaseService;
use App\Traits\CurrencyTrait;
use App\Traits\FileUploadTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class LogisticsCompanyFileService extends BaseService
{
  use FileUploadTrait, CurrencyTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(Request $request): JsonResponse
  {
    return responser()->send(Status::HTTP_OK, $request->all(), '');
  }

}
