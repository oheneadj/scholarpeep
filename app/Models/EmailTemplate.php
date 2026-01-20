<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'subject',
        'preheader',
        'content',
        'description',
    ];

    /**
     * Get the template by slug.
     */
    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', '=', $slug)->first();
    }
}
