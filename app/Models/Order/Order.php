<?php

namespace App\Models\Order;
use App\Models\Currency\SupportedCurrency;
use App\Models\Order\OrderPayment;
use App\Models\Product\Product;
use App\Models\Store\Store;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    'total_amount',
    'store_id',
    'tracking_number',

    'product_id',
    'amount',
    'supported_currency_id',
    'quantity',
    'order_id',
  ];

  public $casts = [
    'total_amount' => 'float'
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
  protected function amount(): Attribute
  {
    return new Attribute(
      get: fn($value) => $value ? ($value/100) : $value,
      set: fn($value) => $value * 100,
    );
  }

  /**
   * @return HasMany
   */
  public function itemsLean(): HasMany
  {
    return $this->hasMany(OrderItem::class)->with([
      'product' => function($query) {
        $query->select([
          'id',
          'name',
          'description',
          'store_id',
          'published',
          'product_category_id',
          'product_unit_id',
          'price',
          'quantity',
          'user_id',
          'tags',
          'currency_id',
        ])->with(['images', 'unit', 'store']);
      }, 'currency' => function($query) {
        $query->select([
          'id',
          'code',
          'name',
          'type',
          'icon'
        ]);
      }
    ]);
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
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  /**
   * @return HasMany
   */
  public function trackings(): HasMany
  {
    return $this->hasMany(OrderTracking::class, 'order_id');
  }

  /**
   * @return BelongsTo
   */
  public function currency(): BelongsTo
  {
    return $this->belongsTo(SupportedCurrency::class, 'supported_currency_id');
  }

  /**
   * @return BelongsTo
   */
  public function store(): BelongsTo
  {
    return $this->belongsTo(Store::class, 'store_id');
  }

  /**
   * @return HasOne
   */
  public function payment(): HasOne
  {
    return $this->hasOne(OrderPayment::class, 'order_id');
  }

}
