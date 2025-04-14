<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycFile extends Model
{
    use HasFactory;

    public $casts = [
        'extras' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kyc_verification_id',
        'extras',
        'file_side',
        'user_id',
        'uploaded_file',
        'description',
        'status',
    ];

    public function kycVerification(): BelongsTo
    {
        return $this->belongsTo(kycVerification::class, 'kyc_verification_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
