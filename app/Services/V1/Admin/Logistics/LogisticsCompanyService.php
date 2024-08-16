<?php

namespace App\Services\V1\Admin\Logistics;
use App\Models\Country;
use App\Models\Logistics\LogisticsCompany;
use App\Services\BaseService;
use App\Traits\V1\CurrencyTrait;
use App\Traits\V1\FileUploadTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class LogisticsCompanyService extends BaseService
{
  use FileUploadTrait, CurrencyTrait;

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(Request $request): JsonResponse
  {
    try {

      $logistics_company = LogisticsCompany::create([
        'name' => $request->name,
        'vehicle_picture' => $this->uploadToS3($request->file('vehicle_picture')),
        'drivers_license' => $this->uploadToS3($request->file('drivers_license')),
        'driver_picture' => $this->uploadToS3($request->file('driver_picture')),
        'state_id' => $request->state_id,
        'plate_number' => $request->plate_number,
        'city_id' => $request->city_id,
        'phone_number' => $request->phone_number,
        'base_price' => $request->base_price,
        'park_address' => $request->park_address,
        'vehicle_type' => $request->vehicle_type,
        'country_id' => Country::where('iso2', 'ng')->first()->id,
        'reference' => $this->generateLogisticsCompanyReference(),
        'currency_id' => $this->getDefaultCurrency()->id,
      ]);

      return Responser::send(Status::HTTP_OK, $logistics_company, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function list(Request $request)
  {
    try {
      $companies = LogisticsCompany::latest()->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $companies, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, null, 'Operation failed. Try again.');
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function update(Request $request): JsonResponse
  {
    try {
      $logistics_company = LogisticsCompany::where('reference', $request->reference)->first();
      if(empty($logistics_company)) {
        throw new Exception('Invalid logistics company record.');
      }

      $logistics_company->update([
        'name' => $request->name,
        'state_id' => $request->state_id,
        'plate_number' => $request->plate_number,
        'city_id' => $request->city_id,
        'phone_number' => $request->phone_number,
        'base_price' => $request->base_price,
        'park_address' => $request->park_address,
        'vehicle_type' => $request->vehicle_type,
      ]);

      return Responser::send(Status::HTTP_OK, $logistics_company, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send($e->getCode(), null, $e->getMessage());
    }
  }

  private function generateLogisticsCompanyReference()
  {
    do {
      $reference = str()->random(64);
    } while (LogisticsCompany::where('reference', $reference)->exists());
    return $reference;
  }

}
