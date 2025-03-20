<?php

namespace App\Http\Controllers\V1\Bank;
use App\Http\Controllers\Controller;
use App\Services\V1\Bank\NigerianBankService;
use Illuminate\Http\JsonResponse;

class NigerianBankController extends Controller
{

    /**
     * @param NigerianBankService $nigerianBank
     */
    public function __construct(private NigerianBankService $nigerianBank)
    {
        $this->nigerianBank = $nigerianBank;
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->nigerianBank->list();
    }

}
