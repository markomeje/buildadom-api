<?php

namespace App\Http\Controllers\V1\Bank;
use App\Http\Controllers\Controller;
use App\Services\V1\Bank\NigerianBankService;
use Illuminate\Http\JsonResponse;

class NigerianBankController extends Controller
{
    public function __construct(private NigerianBankService $nigerianBank)
    {
        $this->nigerianBank = $nigerianBank;
    }

    public function list(): JsonResponse
    {
        return $this->nigerianBank->list();
    }
}
