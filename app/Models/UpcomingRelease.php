<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpcomingRelease extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'release_date',
        'status',
        'product_id',
        'course_id',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
