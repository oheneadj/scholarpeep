<?php

namespace App\Models;

use App\Enums\RequirementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScholarshipRequirement extends Model
{
    use HasFactory;
    protected $fillable = [
        'scholarship_id',
        'type',
        'title',
        'description',
        'is_required',
        'order',
    ];

    protected $casts = [
        'type' => RequirementType::class,
        'is_required' => 'boolean',
        'order' => 'integer',
    ];

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }
}
