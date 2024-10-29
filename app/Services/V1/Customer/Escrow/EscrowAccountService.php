<?php

namespace App\Services\V1\Customer\Escrow;
use App\Http\Resources\V1\Escrow\EscrowAccountResource;
use App\Models\Escrow\EscrowAccount;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;


class EscrowAccountService extends BaseService
{
  /**
   * @return JsonResponse
   */
  public function account(): JsonResponse
  {
    try {
      $account = EscrowAccount::owner()->with([
        'currency',
        'balances' => function($query) {
          $query->latest();
        },
      ])->first();

      $escrow = empty($account) ? null : new EscrowAccountResource($account);
      return responser()->send(Status::HTTP_OK, $escrow, 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}