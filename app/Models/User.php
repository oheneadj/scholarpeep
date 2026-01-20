<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'google_id',
        'facebook_id',
        'avatar',
        'google_calendar_token',
        'education_level_id',
        'field_of_study_id',
        'country_id',
        'gpa',
        'must_reset_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the application documents for the user.
     */
    public function applicationDocuments()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'google_calendar_token' => 'array',
            'last_login_date' => 'date',
            'role' => \App\Enums\UserRole::class,
            'is_active' => 'boolean',
            'must_reset_password' => 'boolean',
        ];
    }
    
    public function canAccessPanel(Panel $panel): bool
    {
        // Only Super Admin and Editor can access the admin panel
        // And they must be active
        return $this->is_active && in_array($this->role, [
            \App\Enums\UserRole::SUPER_ADMIN, 
            \App\Enums\UserRole::EDITOR
        ]);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the user's saved scholarships
     */
    public function savedScholarships()
    {
        return $this->hasMany(SavedScholarship::class);
    }

    /**
     * Get the user's saved searches
     */
    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    /**
     * Get the user's preferences
     */
    public function preference()
    {
        return $this->hasOne(TenantPreference::class);
    }

    /**
     * Get the user's saved resources
     */
    public function savedResources()
    {
        return $this->hasMany(SavedResource::class);
    }

    /**
     * Get the user's points record
     */
    public function points()
    {
        return $this->hasOne(UserPoint::class);
    }

    /**
     * Get the user's point transactions
     */
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Get the user's earned badges
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot(['progress', 'earned_at'])
            ->withTimestamps();
    }

    /**
     * Get only earned badges
     */
    public function earnedBadges()
    {
        return $this->badges()->whereNotNull('user_badges.earned_at');
    }

    /**
     * Get the user's education level
     */
    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }

    /**
     * Get the user's field of study
     */
    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    /**
     * Get the user's country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        if (! app()->isProduction()) {
            return true;
        }

        return ! is_null($this->email_verified_at);
    }
}
