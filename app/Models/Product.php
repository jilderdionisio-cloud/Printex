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
        'supplier_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'purchase_count',
    ];

    protected $casts = [
        'purchase_count' => 'integer',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    // Productos más vendidos (por cantidad de compras)
    public function scopeTopPurchased($query, int $limit = 5)
    {
        return $query->orderByDesc('purchase_count')->take($limit);
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
