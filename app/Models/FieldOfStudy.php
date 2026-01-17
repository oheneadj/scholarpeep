<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldOfStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FieldOfStudy::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FieldOfStudy::class, 'parent_id');
    }

    public function scholarships(): BelongsToMany
    {
        return $this->belongsToMany(Scholarship::class);
    }
}
