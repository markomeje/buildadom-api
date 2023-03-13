<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'expiry',
        'type',
        'verified',
        'code'
    ];

    public function user($type = 'phone')
    {
        return $this->belongsTo(User::class)->where(['type' => $type]);
    }
}
