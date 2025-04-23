<?php

namespace App\Services\V1\Customer\Order;
use App\Models\Driver\DispatchDriver;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderDispatchDriverService extends BaseService
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $user_id = auth()->id();
            $order_id = $request->order_id;

            $driver = DispatchDriver::updateOrCreate([
                'order_id' => $order_id,
                'user_id' => $user_id,
            ],[
                'phone' => formatPhoneNumber($request->phone),
                'user_id' => $user_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'order_id' => $order_id
            ]);

            return responser()->send(Status::HTTP_OK, $driver, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
        }
    }

    /**
     * @param int $order_id
     * @return JsonResponse
     */
    public function show($order_id): JsonResponse
    {
        try {
            $driver = DispatchDriver::owner()->where('order_id', $order_id)->first();
            if(empty($driver)) {
                return responser()->send(Status::HTTP_NOT_FOUND, $driver, 'No driver was set for the order.');
            }

            return responser()->send(Status::HTTP_OK, $driver, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
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
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $driver = DispatchDriver::where(['id' => $request->id, 'user_id' => auth()->id()])->first();
            if (empty($driver)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Driver not found');
            }

            $driver->update([
                'phone' => formatPhoneNumber($request->phone),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'order_id' => $request->order_id
            ]);
            return responser()->send(Status::HTTP_OK, $driver, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
        }
    }

}
