<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id_type',
    'id_number',
    'type',
    'birth_country',
    'state',
    'citizenship_country',
    'fullname',
    'expiry_date',
    'dob',
    'verified',
    'user_id',
    'address',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  public static $types = [
    'drivers license',
    'voters card', 
    'international passport', 
    'national identity card'
  ];

  /**
   * An ID may have many image documents
   * @return Image
   */
  public function image()
  {
    return $this->hasOne(Image::class, 'model_id')->where(['model' => 'identification']);
  }

  /**
   * An ID belongs to a user
   * @return belongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * An ID belongs to a citizenship country
   */
  public function citizenship()
  {
    return $this->belongsTo(Country::class, 'citizenship_country');
  }

  /**
   * An ID belongs to a birth country
   */
  public function birth()
  {
    return $this->belongsTo(Country::class, 'birth_country');
  }
}








