<?php

namespace App\Services\V1\Admin\Logistics;
use App\Models\Logistics\LogisticsCompany;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class LogisticsCompanyService extends BaseService
{

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request)
  {
    try {
      $companies = LogisticsCompany::latest()->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $companies, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
    }
  }

  private function generateLogisticsCompanyReference()
  {
    do {
      $reference = str()->random(64);
    } while (LogisticsCompany::where('reference', $reference)->exists());
    return $reference;
  }

}
