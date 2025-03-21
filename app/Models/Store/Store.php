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
    ];

    public $casts = [
        'published' => 'boolean',
        'extras' => 'json',
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

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
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
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_id');
    }

}
