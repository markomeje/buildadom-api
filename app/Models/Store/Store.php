<?php

namespace App\Models\Store;
use App\Models\City\City;
use App\Models\Country;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class Store extends Model
{
    use HasFactory;

    public $casts = [
        'published' => 'boolean',
        'extras' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'state_id',
        'address',
        'user_id',
        'country_id',
        'logo',
        'published',
        'city_id',
        'extras',
        'banner',
        'ref',
        'slug',
    ];

    /**
     * Scope published stores
     */
    public function scopePublished($query)
    {
        return $query->where(['published' => true]);
    }

    /**
     * @return Builder
     */
    public function scopeOwner($query)
    {
        return $query->where(['user_id' => auth()->id()]);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_id');
    }
}
