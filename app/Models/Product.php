<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'slug', 
        'price', 
        'stock', 
        'description', 
        'image', 
        'status', // Changed from is_active to status
        'is_popular',
        'category_id'
    ];

    // Accessor to keep view compatibility if needed, or we explicitly change view.
    // View uses $product->is_active logic in some places? 
    // Actually the controller was mapping 'active'/'inactive' to is_active boolean.
    // Now we map back to 'status' enum.

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/400x300?text=No+Image';
        }

        if (strpos($this->image, 'http') === 0) {
            return $this->image;
        }

        // Clean up the path
        $path = $this->image;
        
        // Remove 'storage/' if it already exists at the beginning
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, 8);
        }
        
        // Remove leading slash if any
        $path = ltrim($path, '/');

        return asset('storage/' . $path);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }
}
