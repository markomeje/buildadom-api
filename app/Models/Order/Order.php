<?php

namespace App\Models\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Currency;
use App\Models\Order\OrderFulfillment;
use App\Models\Order\OrderPayment;
use App\Models\Payment\Payment;
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
        'customer_id',
        'status',
        'total_amount',
        'store_id',
        'tracking_number',
        'product_id',
        'amount',
        'currency_id',
        'quantity',
    ];

    public $casts = [
        'total_amount' => 'float',
        'amount' => 'float'
    ];

    /**
     * @return Builder
     */
    public function scopeOwner($query)
    {
        return $query->where(['customer_id' => auth()->id()]);
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
     * @return Builder
     */
    public function scopeIsPending($query)
    {
        return $query->where(['status' => OrderStatusEnum::PENDING->value]);
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
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
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
        return $this->belongsTo(Currency::class, 'currency_id');
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

    /**
     * @return HasOne
     */
    public function fulfillment(): HasOne
    {
        return $this->hasOne(OrderFulfillment::class, 'order_id');
    }

}
