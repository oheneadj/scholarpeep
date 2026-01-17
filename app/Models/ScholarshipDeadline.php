<?php

namespace App\Models;

use App\Enums\DeadlineType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScholarshipDeadline extends Model
{
    use HasFactory;
    protected $fillable = [
        'scholarship_id',
        'type',
        'date',
        'description',
    ];

    protected $casts = [
        'type' => DeadlineType::class,
        'date' => 'date',
    ];

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }
}
