<?php

namespace App\Services\V1\Merchant\Bank;
use App\Models\Bank\BankAccount;
use App\Services\BaseService;
use App\Utility\Help;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BankAccountService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function add(Request $request): JsonResponse
  {
    try {
      $account = BankAccount::create([
        'account_name' => $request->account_name,
        'user_id' => auth()->id(),
        'account_number' => $request->account_number,
        'bank_id' => $request->bank_id,
      ]);

      return Responser::send(Status::HTTP_OK, $account, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @return JsonResponse
   */
  public function details(): JsonResponse
  {
    try {
      $account = BankAccount::owner()->with(['bank'])->first();
      return Responser::send(Status::HTTP_OK, $account, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function update(Request $request): JsonResponse
  {
    try {
      $account = BankAccount::owner()->first();
      if(empty($account)) {
        return Responser::send(Status::HTTP_NOT_FOUND, [], 'Bank details not found');
      }

      $account->update([
        'account_name' => $request->account_name,
        'account_number' => $request->account_number,
        'bank_id' => $request->bank_id,
      ]);

      return Responser::send(Status::HTTP_OK, $account, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}
