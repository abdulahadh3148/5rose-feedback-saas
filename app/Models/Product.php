<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'category_id', 'description', 'price', 'image', 'is_available', 'show_on_pos', 'show_on_website', 'sort_order'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
            if (file_exists(public_path('images/' . $this->image))) {
                return asset('images/' . $this->image);
            }
            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }
            return asset('storage/' . $this->image);
        }

        // Category-based fallback image if none uploaded
        $catName = strtolower($this->category?->name ?? '');
        if (str_contains($catName, 'juice')) {
            return asset('images/products/mango-juice.jpg');
        }
        if (str_contains($catName, 'shake')) {
            return asset('images/products/chocolate-milkshake.jpg');
        }
        if (str_contains($catName, 'dessert') || str_contains($catName, 'falooda')) {
            return asset('images/products/rose-falooda.jpg');
        }
        if (str_contains($catName, 'food') || str_contains($catName, 'shawarma')) {
            return asset('images/products/chicken-shawarma.jpg');
        }
        if (str_contains($catName, 'snack')) {
            return asset('images/products/snacks.jpg');
        }

        return asset('images/5rose/logo.png');
    }
}
