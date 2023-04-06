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
    'drivers liscence', 
    'voters card', 
    'international passport', 
    'national identity card'
  ];

  /**
   * An ID has one image
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
}








