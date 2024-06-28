<?php

namespace App\Services\V1\Admin\Merchant;
use App\Enums\User\UserRoleEnum;
use App\Models\User;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MerchantService extends BaseService
{

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $merchants = User::withWhereHas('roles', function($query) {
        $query->where(['name' => UserRoleEnum::MERCHANT->value]);
      })->paginate($request->limit ?? 20);

      return Responser::send(Status::HTTP_OK, $merchants, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, $e->getMessage());
    }
  }

}
