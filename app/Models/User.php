<?php

namespace App\Models;
use App\Models\Bank\BankAccount;
use App\Models\Business\BusinessProfile;
use App\Models\Email\EmailVerification;
use App\Models\Escrow\EscrowAccount;
use App\Models\Phone\PhoneVerification;
use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'address',
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

    public function getAuthPasswordName()
    {}

    /**
     * Get the user's full name.
     */
    public function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->firstname) . ' ' . ucfirst($this->lastname),
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
     */
    public function routeNotificationForAfricasTalking($notification): string
    {
        return $this->phone;
    }

    public function phoneVerification(): HasOne
    {
        return $this->hasOne(PhoneVerification::class)->select(['id', 'user_id', 'verified', 'expiry', 'created_at', 'verified_at']);
    }

    public function emailVerification(): HasOne
    {
        return $this->hasOne(EmailVerification::class)->select(['id', 'user_id', 'verified', 'expiry', 'created_at', 'verified_at']);
    }

    /**
     * A user may have One business profile
     */
    public function businessProfile()
    {
        return $this->hasOne(BusinessProfile::class);
    }

    /**
     * A user may have a many roles
     */
    public function roles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    /**
     * A user may have a many roles
     */
    public function stores()
    {
        return $this->hasMany(Store::class, 'user_id');
    }

    public function bank(): HasOne
    {
        return $this->hasOne(BankAccount::class, 'user_id');
    }

    public function escrow(): HasOne
    {
        return $this->hasOne(EscrowAccount::class, 'user_id');
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => formatPhoneNumber($value)
        );
    }
}
