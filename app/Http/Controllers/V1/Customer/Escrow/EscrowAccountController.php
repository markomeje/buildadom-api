<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Escrow;
use App\Http\Controllers\Controller;
use App\Services\V1\Customer\Escrow\EscrowAccountService;
use Illuminate\Http\JsonResponse;

class EscrowAccountController extends Controller
{
    public function __construct(private EscrowAccountService $escrowAccountService)
    {
        $this->escrowAccountService = $escrowAccountService;
    }

    public function account(): JsonResponse
    {
        return $this->escrowAccountService->account();
    }
}
