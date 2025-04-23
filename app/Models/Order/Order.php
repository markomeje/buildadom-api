<?php

namespace App\Models\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Currency;
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

    public $casts = [
        'total_amount' => 'float',
        'amount' => 'float',
        'has_driver' => 'float',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'status',
        'total_amount',
        'store_id',
        'tracking_number',
        'product_id',
        'amount',
        'currency_id',
        'quantity',
        'has_driver',
    ];

    /**
     * @return Builder
     */
    public function scopeOwner($query)
    {
        return $query->where(['customer_id' => auth()->id()]);
    }

    /**
     * @return Builder
     */
    public function scopeIsPending($query)
    {
        return $query->where(['status' => OrderStatusEnum::PENDING->value]);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function trackings(): HasMany
    {
        return $this->hasMany(OrderTracking::class, 'order_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(OrderPayment::class);
    }

    // public function payment()
    // {
    //     return $this->hasOneThrough(
    //         Payment::class,
    //         OrderPayment::class,
    //         'order_id',
    //         'id',
    //         'id',
    //         'payment_id'
    //     );
    // }

    public function fulfillment(): HasOne
    {
        return $this->hasOne(OrderFulfillment::class, 'order_id');
    }

    protected function totalAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? ($value / 100) : $value,
            set: fn ($value) => $value * 100,
        );
    }

    protected function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? ($value / 100) : $value,
            set: fn ($value) => $value * 100,
        );
    }
}
