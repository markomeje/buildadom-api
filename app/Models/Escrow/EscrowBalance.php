<?php

declare(strict_types=1);

namespace App\Models\Escrow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowBalance extends Model
{
    use HasFactory;

    public $casts = [
        'escrow_account_id' => 'int',
        'old_balance' => 'float',
        'amount' => 'float',
        'new_balance' => 'float',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'escrow_account_id',
        'old_balance',
        'amount',
        'new_balance',
        'balance_type',
        'user_id',
    ];
}
