<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'image', // Standardized to image
        'description', 
        'is_published'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/400x320?text=No+Image';
        }

        if (strpos($this->image, 'http') === 0) {
            return $this->image;
        }

        // Remove 'storage/' if it already exists at the beginning to avoid duplication
        $path = $this->image;
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, 8);
        }

        return asset('storage/' . $path);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}