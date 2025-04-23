<?php

namespace App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class DispatchDriver extends Model
{
    use HasFactory;

    public $casts = [
        'order_id' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'phone',
        'order_id',
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
}
