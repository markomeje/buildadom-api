<?php

namespace App\Http\Controllers\V1\Customer\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Driver\CreateDispatchDriverRequest;
use App\Http\Requests\V1\Merchant\Driver\UpdateDispatchDriverRequest;
use App\Services\V1\Customer\Order\OrderDispatchDriverService;
use Illuminate\Http\JsonResponse;

class OrderDispatchDriverController extends Controller
{
    /**
     * @param \App\Services\V1\Customer\Order\OrderDispatchDriverService $dispatchDriverService
     */
    public function __construct(private OrderDispatchDriverService $dispatchDriverService)
    {
        $this->dispatchDriverService = $dispatchDriverService;
    }

    /**
     * @param \App\Http\Requests\V1\Merchant\Driver\CreateDispatchDriverRequest $request
     * @return JsonResponse
     */
    public function add(CreateDispatchDriverRequest $request)
    {
        return $this->dispatchDriverService->add($request);
    }

    /**
     * @param int $order_id
     * @return JsonResponse
     */
    public function show($order_id)
    {
        return $this->dispatchDriverService->show($order_id);
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        return $this->dispatchDriverService->list();
    }

    /**
     * @param \App\Http\Requests\V1\Merchant\Driver\UpdateDispatchDriverRequest $request
     * @return JsonResponse
     */
    public function update(UpdateDispatchDriverRequest $request)
    {
        return $this->dispatchDriverService->update($request);
    }
}
