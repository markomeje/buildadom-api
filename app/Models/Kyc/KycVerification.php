<?php

namespace App\Models\Kyc;
use App\Models\User;
use App\Models\City\City;
use App\Models\UploadedFile;
use App\Models\SupportedCountry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    'id_number',
    'birth_country',
    'city_id',
    'citizenship_country',
    'fullname',
    'document_expiry_date',
    'birth_date',
    'verified',
    'user_id',
    'address',
  ];

  public $casts = [
    'verified' => 'boolean'
  ];

  public function document()
  {
    return $this->morphMany(UploadedFile::class, 'uploadable');
  }

  /**
   * A kyc verification belongs to a user
   *
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * An kyc verification belongs to a citizenship country
   *
   * @return BelongsTo
   */
  public function citizenshipCountry(): BelongsTo
  {
    return $this->belongsTo(SupportedCountry::class, 'citizenship_country');
  }

  /**
   * An kyc verification belongs to a birth country
   *
   * @return BelongsTo
   */
  public function birthCountry(): BelongsTo
  {
    return $this->belongsTo(SupportedCountry::class, 'birth_country');
  }

  /**
   * An kyc verification belongs to a user
   *
   * @return BelongsTo
   */
  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class, 'city_id');
  }

}








