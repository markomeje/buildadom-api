<?php

namespace App\Models\Escrow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowTransaction extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'escrow_account_id',
    'user_id',
    'order_id',
    'status',
    'transaction_type',
    'message',
  ];

  public $casts = [
    'escrow_account_id' => 'int'
  ];
}
