<?php

namespace App\Services\V1\Customer\Driver;
use App\Models\Driver\DispatchDriver;
use App\Services\BaseService;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DispatchDriverService extends BaseService
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $user_id = auth()->id();
            $phone = formatPhoneNumber($request->phone);

            $driver = DispatchDriver::updateOrCreate([
                'phone' => $phone,
                'user_id' => $user_id,
            ], [
                'phone' => formatPhoneNumber($request->phone),
                'user_id' => $user_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
            ]);

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
            $drivers = DispatchDriver::latest()->owner()->get();
            if (empty($drivers->count())) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'No dispatch driver(s) found.');
            }

            return responser()->send(Status::HTTP_OK, $drivers, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        try {
            $driver = DispatchDriver::owner()->find($id);
            if (empty($driver)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Driver not found');
            }

            $driver->update([
                'phone' => formatPhoneNumber($request->phone),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
            ]);
            return responser()->send(Status::HTTP_OK, $driver, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
        }
    }
}
