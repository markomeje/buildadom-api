<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'location',
        'description',
        'address',
        'user_id',
        'city',
        'status',
        'country_id',
    ];

    /**
     * A store belongs to a country
     * @return Country
     */
    public function country(): Country
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
