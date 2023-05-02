<?php


namespace App\Services;
use App\Models\{Product, Country};
use \Exception;


class ProductService
{
  /**
   * Create product
   *
   * @param array $data
   */
  public function create(array $data)
  {
    return Product::create([
      'user_id' => auth()->id(),
      'published' => false,
      ...$data
    ]);
  }

  /**
   * Update product
   *
   * @param array $data int $id
   */
  public function update(int $id, array $data)
  {
    return Product::findOrFail($id)->update($data);
  }

  /**
   * Get Product
   * @param array $data, int $id
   */
  public static function where(array $data, $id)
  {
    return Product::with(['images', 'category'])->where([
      ...$data,
      'id' => $id
    ])->first();
  }
}












