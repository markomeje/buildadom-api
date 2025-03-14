<?php

namespace App\Services\V1\Merchant\Payment;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PaymentService extends BaseService
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $payments = Payment::owner()->with(['order_payment', 'currency'])->latest()->paginate($request->limit ?? 20);
            return responser()->send(Status::HTTP_OK, $payments, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }

}
