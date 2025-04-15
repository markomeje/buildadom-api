<?php

namespace App\Http\Controllers\V1\Admin\Merchant;
use App\Http\Controllers\Controller;
use App\Services\V1\Admin\Merchant\MerchantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function __construct(private MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    /**
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        return $this->merchantService->list($request);
    }
}
