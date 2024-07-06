<?php

namespace App\Services\V1\Bank;
use App\Integrations\Paystack;
use App\Jobs\V1\Payment\CreatePaystackTransferRecipientJob;
use App\Models\Bank\BankAccount;
use App\Models\Bank\NigerianBank;
use App\Services\BaseService;
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
  public function save(Request $request): JsonResponse
  {
    try {
      $bank = NigerianBank::find($request->bank_id);
      $account_number = (string)$request->account_number;
      $bank_code = $bank->code;

      $resolve = Paystack::payment()->resolveAccountNumber($account_number, $bank_code);
      if(($resolve['status'] ?? 0) === false) {
        return Responser::send(Status::HTTP_OK, null, $resolve['message']);
      }

      $user_id = auth()->id();
      $account = BankAccount::updateOrCreate([
        'user_id' => $user_id,
        'account_number' => $account_number
      ], [
        'account_name' => $resolve['data']['account_name'],
        'user_id' => $user_id,
        'account_number' => $account_number,
        'nigerian_bank_id' => $bank->id,
        'bank_code' => $bank_code,
        'bank_name' => $bank->name ?? '',
      ]);

      CreatePaystackTransferRecipientJob::dispatch();
      return Responser::send(Status::HTTP_OK, $account, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
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
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

}
