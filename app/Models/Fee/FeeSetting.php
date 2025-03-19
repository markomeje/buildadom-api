<?php

namespace App\Models\Fee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'currency_id',
        'description',
        'amount',
        'type',
    ];

    public $casts = [
        'total_amount' => 'float',
        'amount' => 'float'
    ];
}
