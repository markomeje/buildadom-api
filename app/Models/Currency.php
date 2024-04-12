<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Currency extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'symbol',
    'is_supported',
    'code',
    'status',
    'is_default'
  ];

  public $casts = [
    'is_supported' => 'boolean',
    'is_default' => 'boolean',
  ];

  /**
   * @return Builder
   */
  public function scopeIsSupported($query)
  {
    return $query->where('is_supported', 1);
  }

  /**
   * @return Builder
   */
  public function scopeIsDefault($query)
  {
    return $query->where('is_default', 1);
  }

}
