<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
