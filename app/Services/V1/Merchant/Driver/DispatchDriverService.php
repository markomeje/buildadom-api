<?php

namespace App\Services\V1\Merchant\Driver;
use App\Models\Driver\DispatchDriver;
use App\Services\BaseService;
use App\Utility\Help;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DispatchDriverService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function add(Request $request): JsonResponse
  {
    try {
      $phone = Help::formatPhoneNumber($request->phone);
      $driver = DispatchDriver::create([
        'phone' => $phone,
        'user_id' => auth()->id(),
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
      ]);

      return Responser::send(Status::HTTP_OK, $driver, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @return JsonResponse
   */
  public function list(): JsonResponse
  {
    try {
      $drivers = DispatchDriver::owner()->get();
      return Responser::send(Status::HTTP_OK, $drivers, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function update(Request $request): JsonResponse
  {
    try {
      $driver = DispatchDriver::where(['id' => $request->id, 'user_id' => auth()->id()])->first();
      if(empty($driver)) {
        return Responser::send(Status::HTTP_NOT_FOUND, [], '.Driver not found');
      }

      $driver->update([
        'phone' => Help::formatPhoneNumber($request->phone),
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
      ]);

      return Responser::send(Status::HTTP_OK, $driver, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}