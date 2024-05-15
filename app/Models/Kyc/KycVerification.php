<?php

namespace App\Models\Kyc;
use App\Models\Country;
use App\Models\Country\SupportedCountry;
use App\Models\Document\DocumentType;
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
    return $this->belongsTo(Country::class, 'citizenship_country');
  }

  /**
   * @return HasMany
   */
  public function kycFiles(): HasMany
  {
    return $this->hasMany(KycFile::class);
  }

  /**
   * @return BelongsTo
   */
  public function birthCountry(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'birth_country');
  }

  /**
   * @return BelongsTo
   */
  public function documentType(): BelongsTo
  {
    return $this->belongsTo(DocumentType::class, 'document_type_id');
  }

}
