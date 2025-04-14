<?php

declare(strict_types=1);

namespace App\Models;
use App\Models\City\City;
use App\Models\State\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class Country extends Model
{
    use HasFactory;

    public $casts = [
        'translations' => 'json',
        'timezones' => 'json',
        'is_supported' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'latitude',
        'longitude',
        'iso2',
        'capital',
        'iso3',
        'name',
        'phone_code',
        'region',
        'status',
        'flag_url',
        'emoji',
        'translations',
        'timezones',
        'emoji',
        'sub_region',
    ];

    /**
     * @return Builder
     */
    public function scopeIsSupported($query)
    {
        return $query->where('is_supported', 1);
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }
}
