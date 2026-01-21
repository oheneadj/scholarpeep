<?php

namespace App\Models;

use App\Enums\SponsorshipTier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scholarship extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'eligibility_criteria',
        'provider_name',
        'provider_logo',
        'featured_image',
        'award_amount',
        'currency',
        'application_url',
        'primary_deadline',
        'is_rolling',
        'sponsorship_tier',
        'sponsorship_start_date',
        'sponsorship_end_date',
        'sponsorship_notes',
        'meta_title',
        'meta_description',
        'is_active',
        'status',
        'views_count',
        'clicks_count',
        'applications_count',
    ];

    protected $casts = [
        'primary_deadline' => 'date',
        'sponsorship_start_date' => 'date',
        'sponsorship_end_date' => 'date',
        'is_rolling' => 'boolean',
        'is_active' => 'boolean',
        'status' => \App\Enums\ScholarshipStatus::class,
        'sponsorship_tier' => SponsorshipTier::class,
        'award_amount' => 'decimal:2',
        'views_count' => 'integer',
        'clicks_count' => 'integer',
        'applications_count' => 'integer',
    ];

    // Relationships
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }

    public function educationLevels(): BelongsToMany
    {
        return $this->belongsToMany(EducationLevel::class);
    }

    public function fieldsOfStudy(): BelongsToMany
    {
        return $this->belongsToMany(FieldOfStudy::class);
    }

    public function scholarshipTypes(): BelongsToMany
    {
        return $this->belongsToMany(ScholarshipType::class);
    }

    public function deadlines(): HasMany
    {
        return $this->hasMany(ScholarshipDeadline::class);
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(ScholarshipRequirement::class)->orderBy('order');
    }

    public function savedScholarships(): HasMany
    {
        return $this->hasMany(SavedScholarship::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Query Scopes
    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
    }

    public function scopeFeatured($query)
    {
        return $query->where('sponsorship_tier', SponsorshipTier::FEATURED);
    }

    public function scopePremium($query)
    {
        return $query->where('sponsorship_tier', SponsorshipTier::PREMIUM);
    }

    public function scopeSponsored($query)
    {
        return $query->whereIn('sponsorship_tier', [SponsorshipTier::FEATURED, SponsorshipTier::PREMIUM]);
    }

    // Helper Methods
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isFeatured(): bool
    {
        return $this->sponsorship_tier === SponsorshipTier::FEATURED;
    }

    public function isPremium(): bool
    {
        return $this->sponsorship_tier === SponsorshipTier::PREMIUM;
    }

    public function isSponsored(): bool
    {
        return $this->sponsorship_tier !== SponsorshipTier::STANDARD;
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (\Illuminate\Support\Str::contains($this->featured_image, 'http')) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }

        return 'https://images.unsplash.com/photo-152305085306e-8c44f2322a5e?auto=format&fit=crop&q=80&w=1200';
    }

    public function getProviderLogoUrlAttribute(): string
    {
        if ($this->provider_logo) {
            if (\Illuminate\Support\Str::contains($this->provider_logo, 'http')) {
                return $this->provider_logo;
            }
            return asset('storage/' . $this->provider_logo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->provider_name) . '&background=eff6ff&color=3b82f6';
    }
}
