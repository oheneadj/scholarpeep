<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'title',
        'story',
        'student_name',
        'student_photo',
        'university',
        'country',
        'is_featured',
        'is_approved',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->student_photo) {
            return \Illuminate\Support\Str::contains($this->student_photo, 'http')
                ? $this->student_photo
                : \Illuminate\Support\Facades\Storage::disk('public')->url($this->student_photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->student_name) . '&color=3b82f6&background=eff6ff';
    }
}
