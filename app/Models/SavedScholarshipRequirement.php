<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedScholarshipRequirement extends Model
{
    protected $fillable = [
        'saved_scholarship_id',
        'scholarship_requirement_id',
        'is_completed',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function savedScholarship(): BelongsTo
    {
        return $this->belongsTo(SavedScholarship::class);
    }

    public function scholarshipRequirement(): BelongsTo
    {
        return $this->belongsTo(ScholarshipRequirement::class);
    }
}
