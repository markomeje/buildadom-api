<?php

namespace App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'payment_id',
    'order_id',
  ];

  /**
   * @return BelongsTo
   */
  public function order(): BelongsTo
  {
    return $this->belongsTo(Order::class, 'order_id');
  }

}
