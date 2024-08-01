<?php

namespace App\Http\Controllers\V1\Logistics;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Logistics\CreateLogisticsCompanyRequest;
use App\Http\Requests\V1\Logistics\UpdateLogisticsCompanyRequest;
use App\Services\V1\Logistics\LogisticsCompanyService;
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
   * @param CreateLogisticsCompanyRequest $request
   * @param JsonResponse
   */
  public function create(CreateLogisticsCompanyRequest $request): JsonResponse
  {
    return $this->logisticsCompanyService->create($request);
  }

  /**
   *
   * @param Request $request
   * @param JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->logisticsCompanyService->list($request);
  }

  /**
   *
   * @param UpdateLogisticsCompanyRequest $request
   * @param JsonResponse
   */
  public function update(UpdateLogisticsCompanyRequest $request): JsonResponse
  {
    return $this->logisticsCompanyService->update($request);
  }

}
