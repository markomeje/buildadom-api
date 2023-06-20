<?php

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Notifications\Notification;

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
   * User types
   *
   * @var array<int, string>
   */
   public static $types = [
      'individual',
      'business'
   ];

   /**
   * Get the user's full name.
   */
   public function fullname()
   {
      return ucwords($this->firstname . ' ' . $this->lastname);
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
   public function verification($type = 'phone')
   {
      return $this->belongsTo(Verification::class)->where(['type' => $type]);
   }

   /**
   * A user has one identification record
   */
   public function identification()
   {
      return $this->hasOne(Identification::class);
   }

   /**
   * A user may have One business account
   */
   public function business()
   {
      return $this->hasOne(Business::class);
   }

   /**
   * A user may have a store
   */
   public function store()
   {
      return $this->hasOne(Store::class);
   }

   /**
   * A user may have a role
   */
   public function role()
   {
      return $this->hasOne(Role::class);
   }

}












