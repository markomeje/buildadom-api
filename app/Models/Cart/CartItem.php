<?php

declare(strict_types=1);

namespace App\Models\Cart;
use App\Models\Product\Product;
use App\Models\Store\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class CartItem extends Model
{
    use HasFactory;

    public $casts = [
        'product_id' => 'int',
        'store_id' => 'int',
        'customer_id' => 'int',
        'quantity' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'quantity',
        'store_id',
        'product_id',
        'status',
    ];

    /**
     * @return Builder
     */
    public function scopeOwner($query)
    {
        return $query->where(['customer_id' => auth()->id()]);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
