<?php

namespace App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class BankAccount extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'account_name',
    'account_number',
    'bank_id',
    'user_id',
  ];

  /**
   * @return Builder
   */
  public function scopeOwner($query)
  {
    return $query->where(['user_id' => auth()->id()]);
  }

  /**
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * @return BelongsTo
   */
  public function bank(): BelongsTo
  {
    return $this->belongsTo(NigerianBank::class, 'bank_id')->select(['id', 'bank_name', 'bank_code']);
  }

}
