<?php


namespace App\Services;


class BaseService
{
  /**
   * Save Account data
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

}
