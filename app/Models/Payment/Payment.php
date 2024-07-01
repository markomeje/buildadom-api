<?php

namespace App\Models\Payment;

use App\Models\Currency;
use App\Models\Escrow\EscrowAccount;
use App\Models\Order\OrderPayment;
use App\Models\Store\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

class Payment extends Model
{
  use HasFactory;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
  protected $fillable = [
    'amount',
    'user_id',
    'status',
    'reference',
    'type',
    'currency_id',
    'payload',
    'response',
  ];

  public $casts = [
    'response' => 'json',
    'payload' => 'json',
  ];

  /**
   * @return Builder
   */
  public function scopeOwner($query)
  {
    return $query->where(['user_id' => auth()->id()]);
  }

  /**
   * @return Attribute
   */
  protected function amount(): Attribute
  {
    return new Attribute(
      get: fn($value) => $value ? ($value/100) : $value,
      set: fn($value) => $value * 100,
    );
  }

  /**
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * @return HasOne
   */
  public function escrow(): HasOne
  {
    return $this->hasOne(EscrowAccount::class, 'payment_id');
  }

  /**
   * @return BelongsTo
   */
  public function currency(): BelongsTo
  {
    return $this->belongsTo(Currency::class, 'currency_id');
  }

  /**
   * @return HasOne
   */
  public function order(): HasOne
  {
    return $this->hasOne(OrderPayment::class, 'order_id');
  }

}
