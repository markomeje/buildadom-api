<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Admin\Kyc;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Kyc\KycVerificationActionRequest;
use App\Services\V1\Admin\Kyc\KycVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KycVerificationController extends Controller
{
    public function __construct(private KycVerificationService $kycVerificationService)
    {
        $this->kycVerificationService = $kycVerificationService;
    }

    /**
     * @return JsonResponse
     */
    public function action($id, KycVerificationActionRequest $request)
    {
        return $this->kycVerificationService->action($id, $request);
    }

    /**
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        return $this->kycVerificationService->list($request);
    }
}
