<?php

namespace App\Services\V1\Bank;
use App\Models\Bank\NigerianBank;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;

class NigerianBankService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $banks = NigerianBank::orderBy('name', 'asc')->get();

            return responser()->send(Status::HTTP_OK, $banks, 'Banks fetched successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Unknown error. Try again.');
        }
    }
}
