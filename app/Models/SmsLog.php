<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsLog extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'phone',
    'message',
    'status',
    'error_message',
    'from'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
