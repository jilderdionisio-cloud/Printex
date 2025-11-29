<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        $publicPath = public_path('storage/' . $this->image);
        if (file_exists($publicPath)) {
            return asset('storage/' . $this->image);
        }

        if (Storage::disk('public')->exists($this->image)) {
            $disk = Storage::disk('public');
            $mime = $disk->mimeType($this->image) ?: 'image/jpeg';

            return 'data:' . $mime . ';base64,' . base64_encode($disk->get($this->image));
        }

        return null;
    }
}
