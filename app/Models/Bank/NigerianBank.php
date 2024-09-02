<?php

namespace App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NigerianBank extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'code',
    'slug',
    'ussd',
    'is_active',
  ];

  public $casts = [
    'is_active' => 'boolean',
  ];
}
