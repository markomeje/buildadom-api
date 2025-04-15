<?php

namespace App\Http\Controllers\V1\Merchant\Driver;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Driver\CreateDispatchDriverRequest;
use App\Http\Requests\V1\Merchant\Driver\UpdateDispatchDriverRequest;
use App\Services\V1\Merchant\Driver\DispatchDriverService;
use Illuminate\Http\JsonResponse;

class DispatchDriverController extends Controller
{
    public function __construct(private DispatchDriverService $dispatchDriverService)
    {
        $this->dispatchDriverService = $dispatchDriverService;
    }

    /**
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
     * @return JsonResponse
     */
    public function update(UpdateDispatchDriverRequest $request)
    {
        return $this->dispatchDriverService->update($request);
    }
}
