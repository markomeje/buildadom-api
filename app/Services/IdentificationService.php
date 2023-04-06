<?php


namespace App\Services;
use App\Models\Identification;


class IdentificationService
{
  /**
   * Save indentification data
   *
   * @return Indentification
   * @param array
   */
  public function save(array $data): Identification
  {
    $identification = self::details();
    if(empty($identification)) {
      return Identification::create([
        'user_id' => auth()->id(),
        ...$data,
        'verified' => false
      ]);
    }

    $identification->update([...$data, 'verified' => false]);
    return $identification;
  }

  /**
   * Identification details
   */
  public static function details()
  {
    return Identification::with(['images'])->where(['user_id' => auth()->id()])->first();
  }
}












