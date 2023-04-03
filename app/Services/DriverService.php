<?php


namespace App\Services;
use App\Models\{Driver, Country};
use \Exception;


class DriverService
{
  /**
   * Add Driver
   *
   * @param array $data
   */
  public function add(array $data): Driver
  {
    return Driver::create([
      'user_id' => auth()->id(),
      ...$data
    ]);
  }

  /**
   * Update Driver
   *
   * @param array $data int $id
   */
  public function update(array $data, int $id): Driver
  {
    if ($Driver = Driver::find($id)) {
      $Driver->update([...$data]);
      return $Driver;
    }else {
      throw new Exception("Driver with id {$id} was not found.");
    }
  }
}












