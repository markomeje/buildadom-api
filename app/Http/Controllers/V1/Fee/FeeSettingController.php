<?php

namespace App\Http\Controllers\V1\Fee;
use App\Http\Controllers\Controller;
use App\Services\V1\Fee\FeeSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{
    /**
     * @param \App\Services\V1\Fee\FeeSettingService $feeSetting
     */
    public function __construct(
        private FeeSettingService $feeSetting
    ) {}

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->feeSetting->list();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        return $this->feeSetting->show($request);
    }

}
