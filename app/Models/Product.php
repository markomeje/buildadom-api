<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    'status',
    'category_id',
    'price',
    'quantity',
    'user_id',
    'attributes',
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
   * A product has many images
   * @return hasMany
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

}