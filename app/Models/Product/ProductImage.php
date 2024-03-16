<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class ProductImage extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'url',
    'product_id',
    'role',
    'extras',
    'user_id'
  ];

  public $casts = [
    'extras' => 'json',
  ];

  /**
   * @return Builder
   */
  public function scopeOwner($query)
  {
    return $query->where(['user_id' => auth()->id()]);
  }
}
