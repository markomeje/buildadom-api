<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentType extends Model
{
    use HasFactory;

    public $casts = [
        'double_sided' => 'boolean',
    ];

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

    public function codify()
    {
        $name = $this->name;
        if (Str::contains($name, ' ')) {
            $name = implode('_', explode(' ', $name));
        }

        return strtoupper($name);
    }
}
