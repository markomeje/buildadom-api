<?php

namespace App\Models\Product;

use App\Models\Currency\Currency;
use App\Models\Product\ProductCategory;
use App\Models\Store\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
  use HasFactory;

    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'description',
    'store_id',
    'published',
    'product_category_id',
    'price',
    'quantity',
    'user_id',
    'tags',
    'currency_id',
    'product_unit_id',
    'extras'
  ];

  public $casts = [
    'tags' => 'json',
    'extras' => 'json',
  ];

  /**
   * Scope published products
   */
  public function scopePublished($query)
  {
    return $query->where(['published' => true]);
  }

  /**
   * @return BelongsTo
   */
  public function category(): BelongsTo
  {
    return $this->belongsTo(ProductCategory::class, 'product_category_id');
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
    return $this->belongsTo(Currency::class);
  }

  /**
   * @return BelongsTo
   */
  public function unit(): BelongsTo
  {
    return $this->belongsTo(ProductUnit::class);
  }

  /**
   * @return BelongsTo
   */
  public function store(): BelongsTo
  {
    return $this->belongsTo(Store::class);
  }

}
