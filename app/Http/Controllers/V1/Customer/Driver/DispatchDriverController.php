<?php

namespace App\Http\Controllers\V1\Customer\Driver;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Driver\CreateDispatchDriverRequest;
use App\Http\Requests\V1\Merchant\Driver\UpdateDispatchDriverRequest;
use App\Services\V1\Customer\Driver\DispatchDriverService;
use Illuminate\Http\JsonResponse;

class DispatchDriverController extends Controller
{
    /**
     * @param \App\Services\V1\Customer\Driver\DispatchDriverService $dispatchDriverService
     */
    public function __construct(private DispatchDriverService $dispatchDriverService)
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
    public function update($id, UpdateDispatchDriverRequest $request)
    {
        return $this->dispatchDriverService->update($id, $request);
    }
}
