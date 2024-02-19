<?php

namespace App\Models\Upload;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'imageable_id',
    'role',
    'imageable_type',
    'filename',
    'url',
    'user_id',
    'name',
    'extras'
  ];

  public $casts = [
    'extras' => 'json'
  ];

  /**
   * Get all of the owning uploadable models.
   */
  public function uploadable()
  {
    return $this->morphTo();
  }
}
