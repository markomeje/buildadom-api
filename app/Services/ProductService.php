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
  public function create(array $data): Product
  {
    return Product::create([
      'user_id' => auth()->id(),
      'status' => 'pending',
      ...$data
    ]);
  }

  /**
   * Update product
   *
   * @param array $data int $id
   */
  public function update(array $data, int $id) : Product
  {
    if ($product = Product::find($id)) {
      $product->update([...$data]);
      return $product;
    }else {
      throw new Exception("Product with id {$id} was not found.");
    }
  }
}












