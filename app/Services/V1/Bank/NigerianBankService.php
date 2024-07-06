<?php

namespace App\Services\V1\Bank;
use App\Integrations\Paystack;
use App\Models\Bank\NigerianBank;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;


class NigerianBankService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    try {
      $banks = NigerianBank::orderBy('name', 'asc')->get();
      return Responser::send(Status::HTTP_OK, $banks, 'Banks fetched successfully.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
    }
  }

}