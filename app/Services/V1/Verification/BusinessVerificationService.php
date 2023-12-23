<?php


namespace App\Services\V1\Verification;
use Exception;
use App\Models\User;
use App\Utility\Responser;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Traits\V1\User\UserTrait;
use Illuminate\Http\JsonResponse;
use App\Facades\V1\SmsSenderFacade;
use App\Models\Verification\BusinessVerification;
use App\Notifications\BusinessVerificationNotification;


class BusinessVerificationService extends BaseService
{
  use UserTrait;

  /**
   * @param BusinessVerification $businessVerification
   * @param User $user
   */
  public function __construct(public BusinessVerification $businessVerification, private User $user)
  {
    $this->businessVerification = $businessVerification;
    $this->user = $user;
  }

  /**
   * Save indentification data
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function save(Request $request): JsonResponse
  {
    try {
      $businessVerification = $this->getBusinessVerificationDetails();
      $user = $this->user->find(auth()->user());
      if(!$this->isBusinnesUser($user)) {
        return Responser::send(JsonResponse::HTTP_FORBIDDEN, [], 'Operation not allowed.');
      }

      if(empty($businessVerification)) {
        $businessVerification = $this->createBusinessVerificationDetails($request);

        return Responser::send(JsonResponse::HTTP_CREATED, [$businessVerification], 'Your ID is awaiting verification. Thank you.');
      }

      if($this->isBusinessVerified($businessVerification)) {
        return Responser::send(JsonResponse::HTTP_OK, [$businessVerification], 'Your ID is already verified. Thank you.');
      }

      $businessVerification->update(['verified' => false]);
      return Responser::send(JsonResponse::HTTP_OK, [$businessVerification], 'Your ID is awaiting verification. Thank you.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * Get business details
   */
  public function getBusinessVerificationDetails()
  {
    return $this->businessVerification->where([
        'user_id' => auth()->id()
      ])->first();
  }

  private function isBusinessVerified(BusinessVerification $businessVerification): bool
  {
    return (bool)$businessVerification->verified === true;
  }

  /**
   * Create business details
   *
   * @param Request $request
   * @return BusinessVerification
   */
  public function createBusinessVerificationDetails(Request $request): ?BusinessVerification
  {
    return $this->businessVerification->create([
      'user_id' => auth()->id(),
      'cac_number' => $request->cac_number,
      'id_type' => $request->id_type,
      'id_number' => $request->id_number,
      'type' => $request->type,
      'birth_country' => $request->birth_country,
      'state' => $request->state,
      'citizenship_country' => $request->citizenship_country,
      'fullname' => $request->fullname ?? null,
      'expiry_date' => $request->expiry_date,
      'dob' => $request->dob,
      'address' => $request->address,
    ]);
  }

}
