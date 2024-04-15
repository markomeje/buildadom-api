<?php

namespace App\Http\Controllers\V1\Customer\Escrow;
use App\Http\Controllers\Controller;
use App\Services\V1\Customer\Escrow\EscrowAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EscrowAccountController extends Controller
{
  /**
   * @param EscrowAccountService $escrowAccountService
   */
  public function __construct(private EscrowAccountService $escrowAccountService)
  {
    $this->escrowAccountService = $escrowAccountService;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function accounts(Request $request): JsonResponse
  {
    return $this->escrowAccountService->accounts($request);
  }

}