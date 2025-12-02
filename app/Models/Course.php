<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\CourseEnrollment;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_hours',
        'modality',
        'slots',
        'instructor',
        'image',
        'enrollment_count',
    ];

    protected $casts = [
        'duration_hours' => 'integer',
        'price' => 'decimal:2',
        'enrollment_count' => 'integer',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    // Cursos con más inscripciones
    public function scopeTopEnrolled($query, int $limit = 5)
    {
        return $query->orderByDesc('enrollment_count')->take($limit);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
