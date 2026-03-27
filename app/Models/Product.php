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
        'description',
        'price',
        'sale_price',
        'quantity',
        'images',
        'category_id',
        'status',
        'is_featured',
        'is_top_product',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'quantity' => 'integer',
        'images' => 'array',
    ];

    protected $appends = ['image_urls', 'primary_image_url'];

    public function getImageUrlsAttribute()
    {
        $urls = [];
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                $urls[] = asset('storage/' . $image);
            }
        }
        return $urls;
    }

    public function getPrimaryImageUrlAttribute()
    {
        $urls = $this->image_urls;
        return !empty($urls) ? $urls[0] : asset('images/default-product.svg');
    }

    public function getImageUrlAttribute()
    {
        return $this->primary_image_url;
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategorized'
        ]);
    }

    /**
     * Get all reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Calculate total sales quantity for the product.
     */
    public function getTotalSalesAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }

    /**
     * Calculate average rating for the product.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

    /**
     * Scope to get top products based on sales and ratings.
     */
    public function scopeTopProducts($query)
    {
        return $query->with(['category', 'reviews', 'orderItems'])
            ->where('status', 'active')
            ->where('is_top_product', true)
            ->orderByRaw('(SELECT COALESCE(SUM(quantity), 0) FROM order_items WHERE product_id = products.id) DESC')
            ->orderByRaw('(SELECT COALESCE(AVG(rating), 0) FROM reviews WHERE product_id = products.id AND is_approved = 1) DESC');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }
}
