<?php

declare(strict_types=1);

namespace App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderFulfillment extends Model
{
    use HasFactory;

    public $casts = [
        'order_id' => 'int',
        'is_confirmed' => 'boolean',
        'payment_authorized' => 'boolean',
        'payment_processed' => 'boolean',
        'customer_id' => 'int',
        'confirmation_code' => 'int',
        'reference' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'payment_authorized',
        'confirmation_code',
        'status',
        'order_id',
        'payment_processed',
        'is_confirmed',
        'confirmed_at',
        'reference',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
