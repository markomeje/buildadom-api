<?php

namespace App\Services\V1\Admin\Payment;
use App\Http\Resources\Admin\PaymentListResource;
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
            $payments = Payment::latest()->with(['currency', 'user'])->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, PaymentListResource::collection($payments), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }
}
