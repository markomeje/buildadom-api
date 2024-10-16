<?php

namespace App\Models\Document;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentType extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'code',
    'double_sided',
    'name',
    'description',
  ];

  public $casts = [
    'double_sided' => 'boolean'
  ];

  public function codify()
  {
    $name = $this->name;
    if(Str::contains($name, ' ')) {
      $name = implode('_', explode(' ', $name));
    }

    return strtoupper($name);
  }
}
