<?php

namespace App\Services\V1\Bank;
use App\Partners\Paystack;
use App\Jobs\Payment\CreatePaystackTransferRecipientJob;
use App\Models\Bank\BankAccount;
use App\Models\Bank\NigerianBank;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BankAccountService extends BaseService
{
    /**
     * @param Request $request
     * @throws Exception
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        try {
            $bank = NigerianBank::find($request->bank_id);
            $account_number = (string)$request->account_number;
            $bank_code = $bank->code;

            $resolve = Paystack::payment()->resolveAccountNumber($account_number, $bank_code);
            if(($resolve['status'] ?? 0) == false) {
                throw new Exception($resolve['message'], Status::HTTP_NOT_ACCEPTABLE);
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
            return responser()->send(Status::HTTP_OK, $account, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send($e->getCode(), null, $e->getMessage());
        }
    }

    /**
     * @return JsonResponse
     */
    public function details(): JsonResponse
    {
        try {
            $account = BankAccount::owner()->with(['bank'])->first();
            return responser()->send(Status::HTTP_OK, $account, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

}
