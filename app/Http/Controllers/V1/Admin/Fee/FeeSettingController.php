<?php

namespace App\Http\Controllers\V1\Admin\Fee;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Kyc\FeeSettingActionRequest;
use App\Services\V1\Admin\Fee\FeeSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{

  /**
   * @param FeeSettingService $FeeSettingService
   */
  public function __construct(private FeeSettingService $FeeSettingService)
  {
    $this->FeeSettingService = $FeeSettingService;
  }

  /**
   * @param $id
   * @param FeeSettingActionRequest $request
   * @return JsonResponse
   */
  // public function action($id, FeeSettingActionRequest $request)
  // {
  //   return $this->FeeSettingService->action($id, $request);
  // }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    return $this->FeeSettingService->list($request);
  }
}
