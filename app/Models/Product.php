<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
class Product extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'image',
        'is_available',
    ];

      protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_available' => 'boolean',
    ];
     // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope for filtering by price range
    public function scopeFilterByPrice(Builder $query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    // Scope for filtering by category
    public function scopeFilterByCategory(Builder $query, $categoryId)
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        return $query;
    }

    // Scope for filtering by availability
    public function scopeFilterByAvailability(Builder $query, $availability)
    {
        if ($availability !== null) {
            if ($availability === 'in_stock' || $availability === '1' || $availability === 1) {
                $query->where('stock_quantity', '>', 0)->where('is_available', true);
            } elseif ($availability === 'out_of_stock' || $availability === '0' || $availability === 0) {
                $query->where(function($q) {
                    $q->where('stock_quantity', '<=', 0)->orWhere('is_available', false);
                });
            }
        }
        return $query;
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}