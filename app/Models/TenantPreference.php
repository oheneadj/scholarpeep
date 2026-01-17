<?php

namespace App\Models;

use App\Enums\NotificationFrequency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantPreference extends Model
{
    protected $fillable = [
        'user_id',
        'preferred_countries',
        'preferred_education_levels',
        'preferred_fields_of_study',
        'preferred_scholarship_types',
        'notification_frequency',
        'notify_new_matches',
        'notify_deadlines',
        'deadline_reminder_days',
        'last_match_notification_sent_at',
        'last_deadline_notification_sent_at',
    ];

    protected $casts = [
        'preferred_countries' => 'array',
        'preferred_education_levels' => 'array',
        'preferred_fields_of_study' => 'array',
        'preferred_scholarship_types' => 'array',
        'notification_frequency' => NotificationFrequency::class,
        'notify_new_matches' => 'boolean',
        'notify_deadlines' => 'boolean',
        'deadline_reminder_days' => 'integer',
        'last_match_notification_sent_at' => 'datetime',
        'last_deadline_notification_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
