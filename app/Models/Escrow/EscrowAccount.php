<?php

namespace App\Models\Escrow;
use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
    'total_amount',
    'extras',
    'customer_id',
    'payment_id',
    'status',
  ];

  public $casts = [
    'extras' => 'json'
  ];

  /**
   * @return Builder
   */
  public function scopeOwner($query)
  {
    return $query->where(['customer_id' => auth()->id()]);
  }

  public function customer(): BelongsTo
  {
    return $this->belongsTo(User::class, 'customer_id');
  }

  public function payment(): BelongsTo
  {
    return $this->belongsTo(Payment::class, 'payment_id');
  }

}
