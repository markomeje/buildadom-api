<?php

namespace App\Http\Controllers\V1\Merchant\Bank;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Bank\CreateBankAccountRequest;
use App\Http\Requests\V1\Merchant\Bank\UpdateBankAccountRequest;
use App\Services\V1\Merchant\Bank\BankAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


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
  public function add(CreateBankAccountRequest $request)
  {
    return $this->bankAccountService->add($request);
  }

  /**
   * @return JsonResponse
   */
  public function details()
  {
    return $this->bankAccountService->details();
  }

  /**
   * @param UpdateBankAccountRequest $request
   * @return JsonResponse
   */
  public function update(UpdateBankAccountRequest $request)
  {
    return $this->bankAccountService->update($request);
  }

}
