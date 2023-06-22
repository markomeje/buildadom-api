<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'status',
    'tracking_number',
    'total_amount'
  ];

  /**
   * An order may have many cart items
   * @return HasMany
   */
  public function cartItems(): HasMany
  {
    return $this->hasMany(Cart::class);
  }

}
