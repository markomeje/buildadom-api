<?php

namespace App\Models\Escrow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EscrowAccount extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'kyc_verification_id',
    'extras',
    'order_id',
    'user_id',
    'payment_id',
    'status',
  ];

  public $casts = [
    'extras' => 'json'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

}
