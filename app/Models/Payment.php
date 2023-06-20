<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  use HasFactory;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
  protected $fillable = [
    'amount',
    'user_id',
    'paid',
    'reference',
    'type',
  ];

  /**
  * A Payment belongs to a user
  */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
