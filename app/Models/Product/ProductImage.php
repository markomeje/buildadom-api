<?php

declare(strict_types=1);

namespace App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class ProductImage extends Model
{
    use HasFactory;

    public $casts = [
        'extras' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'url',
        'product_id',
        'role',
        'extras',
        'user_id',
    ];

    /**
     * @return Builder
     */
    public function scopeOwner($query)
    {
        return $query->where(['user_id' => auth()->id()]);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
