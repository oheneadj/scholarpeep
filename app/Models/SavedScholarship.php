<?php

namespace App\Models;

use App\Enums\ScholarshipStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavedScholarship extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'status',
        'notes',
        'last_notified_at',
    ];

    protected $casts = [
        'status' => \App\Enums\ApplicationStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function requirementProgress(): HasMany
    {
        return $this->hasMany(SavedScholarshipRequirement::class);
    }

    // Query Scopes
    public function scopeByStatus($query, \App\Enums\ApplicationStatus $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSaved($query)
    {
        return $query->where('status', \App\Enums\ApplicationStatus::SAVED);
    }

    public function scopeApplied($query)
    {
        return $query->where('status', \App\Enums\ApplicationStatus::APPLIED);
    }

    public function scopePending($query)
    {
        return $query->where('status', \App\Enums\ApplicationStatus::PENDING);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', \App\Enums\ApplicationStatus::ACCEPTED);
    }
}
