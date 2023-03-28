<?php


namespace App\Services;
use App\Models\{Identification, Country};
use \Exception;


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
    $identification = Identification::where(['user_id' => auth()->id()])->first();
    if(empty($identification)) {
      $identification = Identification::create([
        'user_id' => auth()->id(),
        ...$data
      ]);
    }

    $identification->expiry_date = empty($data['expiry_date']) ? $identification->expiry_date : $data['expiry_date'];
    $identification->dob = empty($data['dob']) ? $identification->dob : $data['dob'];
    $identification->id_number = empty($data['id_number']) ? $identification->id_number : $data['id_number'];
    $identification->address = empty($data['address']) ? $identification->address : $data['address'];
    $identification->id_type = empty($data['id_type']) ? $identification->id_type : $data['id_type'];

    $identification->update();
    return $identification;
  }
}












