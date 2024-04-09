<?php

namespace App\Http\Controllers\V1\Merchant\Driver;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Merchant\Driver\CreateDispatchDriverRequest;
use App\Http\Requests\V1\Merchant\Driver\UpdateDispatchDriverRequest;
use App\Services\V1\Merchant\Driver\DispatchDriverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DispatchDriverController extends Controller
{
  /**
   * @param DispatchDriverService $dispatchDriverService
   */
  public function __construct(private DispatchDriverService $dispatchDriverService)
  {
    $this->dispatchDriverService = $dispatchDriverService;
  }

  /**
   * @param CreateDispatchDriverRequest $request
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
   * @param UpdateDispatchDriverRequest $request
   * @return JsonResponse
   */
  public function update(UpdateDispatchDriverRequest $request)
  {
    return $this->dispatchDriverService->update($request);
  }

}
