<?php

namespace App\Http\Controllers\V1\Bank;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Bank\CreateBankAccountRequest;
use App\Services\V1\Bank\BankAccountService;
use Illuminate\Http\JsonResponse;


class BankAccountController extends Controller
{
  /**
   * @param BankAccountService $bankAccountService
   */
  public function __construct(private BankAccountService $bankAccountService)
  {
    $this->bankAccountService = $bankAccountService;
  }

  /**
   * @param CreateBankAccountRequest $request
   * @return JsonResponse
   */
  public function save(CreateBankAccountRequest $request): JsonResponse
  {
    return $this->bankAccountService->save($request);
  }

  /**
   * @return JsonResponse
   */
  public function details(): JsonResponse
  {
    return $this->bankAccountService->details();
  }

}
