<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'street_address',
        'user_id',
        'city',
        'state',
        'country_id',
        'zip_code',
        'shipping_fee',
        'status',
    ];

    /**
     * A Shipping belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
