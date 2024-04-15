<?php

namespace App\Services\V1\Merchant\Escrow;
use App\Models\Escrow\EscrowAccount;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class EscrowAccountService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function accounts(Request $request): JsonResponse
  {
    try {
      $accounts = EscrowAccount::owner()->latest()->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $accounts, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}