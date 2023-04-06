<?php


namespace App\Services;
use App\Models\Account;


class AccountService
{
  /**
   * Save Account data
   *
   * @return Account
   * @param array
   */
  public function save(array $data): Account
  {
    $account = self::information();
    if(empty($account)) {
      return Account::create([
        'user_id' => auth()->id(),
        ...$data,
      ]);
    }

    $account->update([...$data]);
    return $account;
  }

  /**
   * Account details
   */
  public static function information()
  {
    return Account::where(['user_id' => auth()->id()])->first();
  }
}












