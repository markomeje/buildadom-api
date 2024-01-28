<?php

namespace App\Models\State;

use App\Models\City\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'country_id',
    'name',
    'latitude',
    'longitude',
    'status',
  ];

  /**
   * @return HasMany
   */
  public function cities(): HasMany
  {
    return $this->hasMany(City::class, 'state_id');
  }

}
