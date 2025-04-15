<?php

namespace App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class BankAccount extends Model
{
    use HasFactory;

    public $casts = [
        // 'extras' => 'json',
        'transfer_recipient_created' => 'boolean',
        'nigerian_bank_id' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_name',
        'account_number',
        'extras',
        'transfer_recipient_created',
        'bank_name',
        'nigerian_bank_id',
        'bank_code',
        'recipient_code',
        'user_id',
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

    public function bank(): BelongsTo
    {
        return $this->belongsTo(NigerianBank::class, 'bank_id');
    }
}
