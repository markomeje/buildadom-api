<?php

declare(strict_types=1);

namespace App\Services\V1\Merchant\Payment;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentService extends BaseService
{
    public function list(Request $request): JsonResponse
    {
        try {
            $payments = Payment::owner()
                ->select(['id',
                    'amount',
                    'status',
                    'reference',
                    'fee',
                    'currency_id',
                    'total_amount',
                    'message',
                    'transfer_code',
                    'is_failed',
                ])->where('type', PaymentTypeEnum::TRANSFER->value)
                ->with(['settlement' => function ($q1)
                {
                    $q1->with(['order' => function ($q2)
                    {
                        $q2->select([
                            'id',
                            'total_amount',
                            'product_id',
                            'amount',
                            'quantity',
                            'currency_id',
                            'status',
                        ])->with(['product' => function ($q3)
                        {
                            $q3->with(['images']);
                        }]);
                    }]);
                }, 'currency'])->latest()->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, $payments, 'Payment listed successfully.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }
}
