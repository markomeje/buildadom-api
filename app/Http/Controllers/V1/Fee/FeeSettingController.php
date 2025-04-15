<?php

namespace App\Http\Controllers\V1\Fee;
use App\Http\Controllers\Controller;
use App\Services\V1\Fee\FeeSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{
    public function __construct(
        private FeeSettingService $feeSetting
    ) {}

    public function list(): JsonResponse
    {
        return $this->feeSetting->list();
    }

    public function show(Request $request): JsonResponse
    {
        return $this->feeSetting->show($request);
    }
}
