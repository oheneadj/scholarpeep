<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'filters',
    ];

    protected $casts = [
        'filters' => 'array',
    ];

    /**
     * Get the user that owns the saved search
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the search URL with filters applied
     */
    public function getUrlAttribute(): string
    {
        $queryString = http_build_query($this->filters);
        return route('scholarships.index') . '?' . $queryString;
    }
}
