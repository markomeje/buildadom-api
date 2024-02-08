<?php

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'kyc_verification_id',
    'extras',
    'document_side',
    'document_file',
  ];

  public $casts = [
    'extras' => 'json'
  ];
}
