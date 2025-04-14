<?php

declare(strict_types=1);

namespace App\Services\V1\Currency;
use App\Models\Currency;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;

class CurrencyService extends BaseService
{
    public function list(): JsonResponse
    {
        try {
            $currencies = Currency::latest()->get();

            return responser()->send(Status::HTTP_OK, $currencies, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
        }
    }
}
