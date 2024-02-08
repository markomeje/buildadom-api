<?php

namespace App\Models;

use App\Models\Business\BusinessProfile;
use App\Models\Notification\InappNotification;
use App\Models\Verification\PhoneVerification;
use App\Utility\Help;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
  use HasFactory, Notifiable;

   /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'firstname',
    'email',
    'password',
    'phone',
    'lastname',
    'type',
    'status',
    'address'
  ];

   /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
  ];

   /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [];

  /**
   * Get the user's full name.
   *
   * @return Attribute
   */
  public function fullname(): Attribute
  {
      return Attribute::make(
          get: fn() => ucfirst($this->firstname) . ' ' . ucfirst($this->lastname),
      );
  }

  /**
   *
   * @return Attribute
   */
  protected function email(): Attribute
  {
      return Attribute::make(
          set: fn($value) => strtolower($value)
      );
  }

  /**
   *
   * @return Attribute
   */
  protected function cellphone(): Attribute
  {
      return Attribute::make(
          set: fn($value) => Help::getOnlyNumbers($value)
      );
  }

   /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

   /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }

   /**
   * Route notifications for the Africas Talking channel.
   *
   * @param  \Illuminate\Notifications\Notification  $notification
   * @return string
   */
  public function routeNotificationForAfricasTalking($notification): string
  {
    return $this->phone;
  }

   /**
   * A user may have one veirifcation
   */
  public function phoneVerification()
  {
    return $this->belongsTo(PhoneVerification::class);
  }

   /**
   * A user has one identification record
   */
  public function identification()
  {
    return $this->hasOne(Identification::class);
  }

  /**
   * Override notifications() method in HasDatabaseNotifications trait.
   *
   *
  */
  public function notifications()
  {
    return $this->morphMany(InappNotification::class, 'notifiable')->orderBy('created_at', 'desc');
  }

  /**
   * A user may have One business profile
   */
  public function businessProfile()
  {
    return $this->hasOne(BusinessProfile::class);
  }

   /**
   * A user may have a store
   */
  public function store()
  {
    return $this->hasOne(Store::class);
  }

   /**
   * A user may have a many roles
   */
  public function roles()
  {
    return $this->hasMany(UserRole::class);
  }

}
