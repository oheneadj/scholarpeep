<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'saved_scholarship_id',
        'scholarship_requirement_id',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * Get the saved scholarship that owns the document
     */
    public function savedScholarship()
    {
        return $this->belongsTo(SavedScholarship::class);
    }

    /**
     * Get the requirement this document is for
     */
    public function requirement()
    {
        return $this->belongsTo(ScholarshipRequirement::class, 'scholarship_requirement_id');
    }

    /**
     * Get the file size in human readable format
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the file extension
     */
    public function getFileExtensionAttribute(): string
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }
}
