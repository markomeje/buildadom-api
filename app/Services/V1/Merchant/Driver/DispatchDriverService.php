<?php

namespace App\Services\V1\Merchant\Driver;
use App\Models\Driver\DispatchDriver;
use App\Services\BaseService;
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
            $driver = DispatchDriver::create([
                'phone' => formatPhoneNumber($request->phone),
                'user_id' => auth()->id(),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
            ]);

            return responser()->send(Status::HTTP_OK, $driver, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $drivers = DispatchDriver::owner()->get();
            return responser()->send(Status::HTTP_OK, $drivers, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e->getMessage());
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
                return responser()->send(Status::HTTP_NOT_FOUND, [], 'Driver not found');
            }

            $driver->update([
                'phone' => formatPhoneNumber($request->phone),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
            ]);

            return responser()->send(Status::HTTP_OK, $driver, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
        }
    }

}
