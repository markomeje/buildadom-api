<?php

declare(strict_types=1);

namespace App\Services\V1\Admin\Merchant;
use App\Enums\User\UserRoleEnum;
use App\Http\Resources\Admin\Merchant\MerchantListResource;
use App\Models\User;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MerchantService extends BaseService
{
    public function list(Request $request): JsonResponse
    {
        try {
            $merchants = User::whereHas('roles', function ($query)
            {
                $query->select(['name', 'user_id'])->where(['name' => UserRoleEnum::MERCHANT->value]);
            })->paginate($request->limit ?? 20);

            return responser()->send(Status::HTTP_OK, MerchantListResource::collection($merchants), 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
        }
    }
}
