<?php

namespace App\Models\V1\Orders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
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
    'amount',
    'store_id',
    'quantity',
    'order_id'
  ];

  /**
   * @return BelongsTo
   */
  public function order(): BelongsTo
  {
    return $this->belongsTo(Order::class, 'order_id');
  }

  /**
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  /**
   * @return BelongsTo
   */
  public function trackings(): BelongsTo
  {
    return $this->belongsTo(OrderTracking::class, 'order_item_id');
  }
}
