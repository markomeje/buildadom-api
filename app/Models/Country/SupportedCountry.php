<?php

namespace App\Models\Country;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportedCountry extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'country_id',
    'status',
  ];

  /**
   * @return BelongsTo
   */
  public function country(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'country_id');
  }
}
