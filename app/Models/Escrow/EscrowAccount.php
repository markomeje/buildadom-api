<?php

declare(strict_types=1);

namespace App\Models\Escrow;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EscrowAccount extends Model
{
    use HasFactory;

    public $casts = [
        'extras' => 'json',
        'balance' => 'float',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'balance',
        'currency_id',
        'extras',
        'user_id',
        'status',
    ];

    /**
     * @return Builder
     */
    public function scopeOwner($query)
    {
        return $query->where(['user_id' => auth()->id()]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function balances(): HasMany
    {
        return $this->hasMany(EscrowBalance::class, 'escrow_account_id');
    }
}
