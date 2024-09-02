<?php

namespace App\Models\Payment;
use App\Models\Currency;
use App\Models\Escrow\EscrowAccount;
use App\Models\Order\OrderPayment;
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
    'fee',
    'type',
    'currency_id',
    'payload',
    'initialize_response',
    'total_amount',
    'message',
    'verify_response',
    'webhook_response',
    'transfer_code',
    'is_failed',
  ];

  public $casts = [
    'webhook_response' => 'json',
    'initialize_response' => 'json',
    'verify_response' => 'json',
    'total_amount' => 'float',
    'fee' => 'float',
    'amount' => 'float',
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
   * @return Attribute
   */
  protected function totalAmount(): Attribute
  {
    return new Attribute(
      get: fn($value) => $value ? ($value/100) : $value,
      set: fn($value) => $value * 100,
    );
  }

  /**
   * @return Attribute
   */
  protected function fee(): Attribute
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
   * @return BelongsTo
   */
  public function currency(): BelongsTo
  {
    return $this->belongsTo(Currency::class, 'currency_id');
  }

  /**
   * @return HasOne
   */
  public function orderPayment()
  {
    return $this->hasOne(OrderPayment::class);
  }

}
