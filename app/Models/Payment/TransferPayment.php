<?php

namespace App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferPayment extends Model
{
  use HasFactory;

  /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
  protected $fillable = [
    'amount',
    'currency_id',
    'user_id',
    'status',
    'reference',
    'is_failed',
    'response',
    'transfer_code',
    'message',
  ];

  public $casts = [
    'amount' => 'float',
    'reference' => 'string',
    'response' => 'json',
    'is_failed' => 'boolean'
  ];
}
