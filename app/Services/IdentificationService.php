<?php


namespace App\Services;
use App\Models\{Identification, Country};
use App\Actions\ImageAction;
use App\Http\Requests\SaveImageRequest;
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
      return Identification::create([
        'user_id' => auth()->id(),
        ...$data,
        'verified' => false
      ]);
    }

    $identification->update([...$data, 'verified' => false]);
    return $identification;
  }
}












