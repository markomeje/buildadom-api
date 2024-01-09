<?php

namespace App\Models\Verification;

use App\Models\User;
use App\Models\Country;
use App\Models\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessVerification extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id_type',
    'id_number',
    'type',
    'birth_country',
    'state',
    'citizenship_country',
    'fullname',
    'expiry_date',
    'dob',
    'verified',
    'user_id',
    'address',
    'uploaded_document'
  ];

  public function document()
  {
    return $this->morphMany(UploadedFile::class, 'uploadable');
  }

  /**
   * An ID belongs to a user
   * @return BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * An ID belongs to a citizenship country
   */
  public function citizenshipCountry()
  {
    return $this->belongsTo(Country::class, 'citizenship_country');
  }

  /**
   * An ID belongs to a birth country
   */
  public function birthCountry()
  {
    return $this->belongsTo(Country::class, 'birth_country');
  }
}








