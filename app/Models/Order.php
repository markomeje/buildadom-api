<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'firstname',
    'email',
    'lastname',
    'type',
    'business_name',
    'location',
    'phone',
    'materials',
  ];

  /**
   * Order status
   *
   * @var array<string>
   */
  private $status = ['pending','processing','completed','decline']
}
