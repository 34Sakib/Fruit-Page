<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'description',
        'sku',
        'price',
        'sale_price',
        'quantity',
        'total',
        'options',
        'image',
        'weight',
        'dimensions',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'quantity' => 'integer',
        'total' => 'decimal:2',
        'options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_price',
        'formatted_total',
        'is_on_sale',
        'image',
        'image_url',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the formatted price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return '৳' . number_format($this->price, 2);
    }

    /**
     * Get the formatted total price.
     *
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        return '৳' . number_format($this->total, 2);
    }

    /**
     * Check if the item is on sale.
     *
     * @return bool
     */
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    /**
     * Get the full URL for the product image.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        // Debug: Log the image data
        \Log::info('OrderItem Image Debug', [
            'order_item_id' => $this->id,
            'product_id' => $this->product_id,
            'image_field' => $this->image,
            'options' => $this->options,
            'attributes' => $this->attributes
        ]);

        // First, check if we have an image in the options array
        if (is_array($this->options) && !empty($this->options['image'])) {
            $imageUrl = $this->options['image'];
            \Log::info('Found image in options', ['url' => $imageUrl]);
            return $imageUrl;
        }
        // Fallback to the image field if options is a string (JSON)
        elseif (is_string($this->options)) {
            $options = json_decode($this->options, true);
            if (json_last_error() === JSON_ERROR_NONE && !empty($options['image'])) {
                $imageUrl = $options['image'];
                \Log::info('Found image in JSON options', ['url' => $imageUrl]);
                return $imageUrl;
            }
        }

        // If no image is set in options, check the image field
        if (empty($this->image)) {
            \Log::info('No image set, using default');
            return asset('images/default-product.png');
        }
        
        // Check if the image is already a full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            \Log::info('Image is already a full URL', ['url' => $this->image]);
            return $this->image;
        }
        
        // Try different possible paths
        $possiblePaths = [
            'storage/' . ltrim($this->image, '/'),
            'storage/products/' . ltrim($this->image, '/'),
            'storage/app/public/' . ltrim($this->image, '/'),
            'storage/app/public/products/' . ltrim($this->image, '/')
        ];
        
        foreach ($possiblePaths as $imagePath) {
            $fullPath = public_path($imagePath);
            \Log::info('Checking image path', [
                'path' => $imagePath,
                'exists' => file_exists($fullPath),
                'full_path' => $fullPath
            ]);
            
            if (file_exists($fullPath)) {
                $url = asset($imagePath);
                \Log::info('Found image at path', ['url' => $url]);
                return $url;
            }
        }
        
        // If we get here, no image was found
        \Log::warning('Image not found in any location', ['image' => $this->image]);
        return asset('images/default-product.png');
    }

    /**
     * Calculate the total price for the item.
     *
     * @return $this
     */
    public function calculateTotal()
    {
        $price = $this->isOnSale ? $this->sale_price : $this->price;
        $this->total = $price * $this->quantity;
        return $this;
    }

    /**
     * Scope a query to only include pending items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include fulfilled items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }

    /**
     * Scope a query to only include cancelled items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Mark the item as fulfilled.
     *
     * @return bool
     */
    public function markAsFulfilled()
    {
        return $this->update(['status' => 'fulfilled']);
    }

    /**
     * Mark the item as cancelled.
     *
     * @param string $reason
     * @return bool
     */
    public function markAsCancelled($reason = null)
    {
        return $this->update([
            'status' => 'cancelled',
            'notes' => $reason ?: $this->notes,
        ]);
    }
}
