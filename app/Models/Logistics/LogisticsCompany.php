<?php

namespace App\Models\Logistics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticsCompany extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'plate_number',
    'drivers_license',
    'vehicle_picture',
    'city_id',
    'phone_number',
    'currency_id',
    'base_price',
    'park_address',
    'driver_picture',
    'vehicle_type',
    'country_id',
    'state_id',
    'status',
    'extras',
    'reference',
  ];

  public $casts = [
    'extras' => 'json'
  ];
}
