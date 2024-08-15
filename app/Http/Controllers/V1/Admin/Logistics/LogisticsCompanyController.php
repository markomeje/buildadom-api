<?php

namespace App\Http\Controllers\V1\Admin\Logistics;
use App\Http\Controllers\Controller;
use App\Services\V1\Admin\Logistics\LogisticsCompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogisticsCompanyController extends Controller
{

  /**
   * @param LogisticsCompanyService $logisticsCompanyService
   */
  public function __construct(private LogisticsCompanyService $logisticsCompanyService)
  {
    $this->logisticsCompanyService = $logisticsCompanyService;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->logisticsCompanyService->list($request);
  }

}