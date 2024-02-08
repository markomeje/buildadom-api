<?php

namespace App\Models\Kyc;
use App\Models\Country\SupportedCountry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KycVerification extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'document_type_id',
    'document_number',
    'birth_country',
    'citizenship_country',
    'fullname',
    'document_expiry_date',
    'birth_date',
    'status',
    'user_id',
    'address',
  ];

  public $casts = [];

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
  public function citizenshipCountry(): BelongsTo
  {
    return $this->belongsTo(SupportedCountry::class, 'citizenship_country');
  }

  /**
   * @return HasMany
   */
  public function documents(): HasMany
  {
    return $this->hasMany(KycDocument::class, 'kyc_verification_id');
  }

  /**
   * @return BelongsTo
   */
  public function birthCountry(): BelongsTo
  {
    return $this->belongsTo(SupportedCountry::class, 'birth_country');
  }

}
