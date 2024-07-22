<?php

namespace App\Services\V1\Customer\Escrow;
use App\Http\Resources\V1\Escrow\EscrowAccountResource;
use App\Models\Escrow\EscrowAccount;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class EscrowAccountService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function details(): JsonResponse
  {
    try {
      $account = EscrowAccount::owner()->with(['currency', 'balances' => fn($query) => $query->latest()])->first();
      return Responser::send(Status::HTTP_OK, new EscrowAccountResource($account), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}