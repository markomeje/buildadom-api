<?php

namespace App\Http\Controllers\V1\Admin\Kyc;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Kyc\KycVerificationActionRequest;
use App\Models\City\City;
use App\Services\V1\Admin\Kyc\KycVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KycVerificationController extends Controller
{

  /**
   * @param KycVerificationService $kycVerificationService
   */
  public function __construct(private KycVerificationService $kycVerificationService)
  {
    $this->kycVerificationService = $kycVerificationService;
  }

  /**
   * @param $id
   * @param KycVerificationActionRequest $request
   * @return JsonResponse
   */
  public function action($id, KycVerificationActionRequest $request)
  {
    return $this->kycVerificationService->action($id, $request);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request)
  {
    return $this->kycVerificationService->list($request);
  }
}
