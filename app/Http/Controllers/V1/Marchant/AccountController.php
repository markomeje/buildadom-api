<?php

namespace App\Http\Controllers\V1\Marchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Services\AccountService;
use App\Models\Account;
use \Exception;


class AccountController extends Controller
{

  /**
   * save Account details
   * @param $request, AccountService
   */
  public function save(AccountRequest $request)
  {
    try {
      if($account = (new AccountService())->save($request->validated())) {
        return response()->json([
          'success' => true,
          'message' => 'Account saved successfully',
          'account' => $account,
        ], 201);
      }

      return response()->json([
        'success' => false,
        'message' => 'Operation failed. Try again.',
      ], 500);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

  /**
   * Get Marchant Account information
   */
  public function information()
  {
    try {
      $account = AccountService::information();
      return response()->json([
        'success' => true,
        'message' => 'Account retrieved successfully',
        'account' => $account,
      ], 200);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
        'message' => $error->getMessage(),
      ], 500);
    }
  }

}
