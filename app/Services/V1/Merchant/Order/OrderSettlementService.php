<?php

namespace App\Services\V1\Merchant\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Order\OrderResource;
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
            $stores = auth()->user()->stores;
            $orders = OrderSettlement::whereIn('store_id', $stores->pluck('id')->toArray())
                ->whereNotIn('status', [OrderStatusEnum::CANCELLED->value])
                ->with(['currency', 'trackings', 'fulfillment', 'store', 'product' => function($query) {
                    $query->with(['images', 'category', 'unit', 'currency']);
                }])
                ->latest()
                ->with(['currency', 'payment'])
                ->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, OrderResource::collection($orders), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }

}
