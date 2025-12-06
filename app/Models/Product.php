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

    /**
     * Intenta 4 métodos diferentes para asegurar que la imagen sea accesible
     */
    public function getImageUrlAttribute(): ?string
    {
        // PASO 1: ¿Tiene imagen?
        if (! $this->image) {
            return null;  // Sin imagen → null
        }

        // PASO 2: ¿Es URL externa (http://, https://)?
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }


        // Este es el caso normal: public/storage → storage/app/public/
        $publicPath = public_path('storage/' . $this->image);
        if (file_exists($publicPath)) {
            return asset('storage/' . $this->image);  // Devuelve URL: http://localhost:8000/storage/...
        }


        // Si el symlink está roto, convierte imagen a base64 (data:uri)
        if (Storage::disk('public')->exists($this->image)) {
            $disk = Storage::disk('public');
            
        
            // Si no puede detectar el tipo → usa 'image/jpeg' por defecto
            $mime = $disk->mimeType($this->image) ?: 'image/jpeg';

            // Lee contenido binario → codifica a base64 → retorna en formato data:uri
            return 'data:' . $mime . ';base64,' . base64_encode($disk->get($this->image));
        }

        // PASO 5: No existe en ningún lado → null
        return null;
    }
}
