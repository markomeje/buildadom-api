<?php

namespace App\Services\V1\Merchant\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Order\OrderSettlementResource;
use App\Models\Order\OrderSettlement;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderSettlementService extends BaseService
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $settlements = OrderSettlement::query()
                ->where('merchant_id', auth()->id())
                ->whereNotIn('status', [OrderStatusEnum::CANCELLED->value])
                ->latest()
                ->with(['order' => function($q1) {
                    $q1->with(['product' => function($q2) {
                        $q2->with(['images', 'category', 'unit', 'currency']);
                    }]);
                }, 'payment'])
                ->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, OrderSettlementResource::collection($settlements), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

}
