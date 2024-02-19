<?php

namespace App\Models\Product;

use App\Models\V1\Product\ProductUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    'category_id',
    'price',
    'quantity',
    'user_id',
    'attributes',
    'currency_id',
    'unit_id'
  ];

  /**
   * Product status
   *
   * @var array<string>
   */
  private $status = [
    'active',
    'pending',
  ];

  /**
   * Scope published products
   */
  public function scopePublished($query)
  {
    return $query->where(['published' => true]);
  }

  /**
   * A product has many images
   * @return HasMany
   */
  public function images()
  {
    return $this->hasMany(Image::class, 'model_id')->where(['model' => 'product']);
  }

  /**
   * A product belongs to a category
   */
  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  /**
   * A product belongs to a user
   * @return User
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * A product belongs to a currency
   */
  public function currency()
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
