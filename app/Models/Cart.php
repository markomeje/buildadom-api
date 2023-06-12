<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'product_id',
    'status',
    'user_id',
  ];

  /**
   * An item belongs to a product
   * @return belongsTo
   */
  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

}
