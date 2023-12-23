<?php

namespace App\Models\V1\Orders;
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
    'product_id',
    'total_amount',
    'store_id',
    'notes',
    'quantity',
    'order_ref'
  ];

  /**
   * @return HasMany
   */
  public function items(): HasMany
  {
    return $this->hasMany(orderItem::class);
  }

}
