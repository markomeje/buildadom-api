<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
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
    'address',
    'user_id',
    'city',
    'country_id',
    'published'
  ];

  /**
   * Scope published stores
   */
  public function scopePublished($query)
  {
    return $query->where(['published' => true]);
  }

  /**
   * A store has many images
   * @return HasMany
   */
  public function images()
  {
    return $this->hasMany(Image::class, 'model_id')->where(['model' => 'store']);
  }

   /**
   * A store belongs to a country
   * @return Country
   */
  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id');
  }

   /**
   * A store belongs to a user
   * @return User
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * A store has many products
   * @return hasMany
   */
  public function products()
  {
    return $this->hasMany(Product::class)->with(['images', 'currency']);
  }
}
