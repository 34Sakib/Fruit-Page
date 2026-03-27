<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'subtotal',
        'tax',
        'discount',
        'shipping_cost',
        'total',
        'payment_method',
        'payment_status',
        'delivery_method',
        'delivery_status',
        'notes',
        'ip_address',
        'status',
        'shipping_address_id',
        'billing_address_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    /**
     * The possible order statuses in sequence.
     *
     * @var array
     */
    const STATUSES = [
        'pending',
        'processing',
        'shipped',
        'delivered',
        'completed',
        'cancelled',
        'refunded'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
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
        'full_name',
        'formatted_total',
        'formatted_created_at',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shipping address for the order.
     */
    public function shippingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'shipping_address_id');
    }

    /**
     * Get the billing address for the order.
     */
    public function billingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'billing_address_id');
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all status updates for the order.
     */
    public function statusUpdates()
    {
        return $this->hasMany(OrderStatusUpdate::class)->latest();
    }

    /**
     * Scope a query to only include orders with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the next possible statuses for this order.
     */
    public function getNextStatusesAttribute()
    {
        $currentIndex = array_search($this->status, self::STATUSES);
        
        if ($currentIndex === false) {
            return [];
        }

        return array_slice(self::STATUSES, $currentIndex + 1);
    }

    /**
     * Check if the order can be updated to the given status.
     */
    public function canUpdateToStatus($status)
    {
        // If status is the same, no need to update
        if ($this->status === $status) {
            return false;
        }

        // If status is cancelled or completed, no further updates allowed
        if (in_array($this->status, ['cancelled', 'completed', 'refunded'])) {
            return false;
        }

        $currentIndex = array_search($this->status, self::STATUSES);
        $newIndex = array_search($status, self::STATUSES);

        // If either status is not found, disallow
        if ($currentIndex === false || $newIndex === false) {
            return false;
        }

        // Only allow moving forward in status
        return $newIndex > $currentIndex;
    }

    /**
     * Update the order status if valid.
     */
    public function updateStatus($newStatus, $notes = null, $userId = null)
    {
        if (!$this->canUpdateToStatus($newStatus)) {
            return false;
        }

        // Update the status
        $previousStatus = $this->status;
        $this->status = $newStatus;
        
        // Set timestamps for specific statuses
        if ($newStatus === 'shipped') {
            $this->shipped_at = now();
        } elseif ($newStatus === 'delivered') {
            $this->delivered_at = now();
        } elseif ($newStatus === 'completed') {
            $this->completed_at = now();
        }

        $this->save();

        // Record the status update
        $this->statusUpdates()->create([
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
            'user_id' => $userId ?? auth()->id()
        ]);

        return true;
    }

    /**
     * Get the full name of the customer.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
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
     * Get the formatted created at date.
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('M d, Y h:i A') : 'N/A';
    }

    /**
     * Scope a query to only include pending orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Generate a unique order number.
     *
     * @return string
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $latest = static::where('order_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($latest) {
            $number = (int) str_replace($prefix, '', $latest->order_number) + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if the order is paid.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if the order is pending payment.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if the order is cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Mark the order as paid.
     *
     * @return bool
     */
    public function markAsPaid()
    {
        return $this->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);
    }

    /**
     * Mark the order as completed.
     *
     * @return bool
     */
    public function markAsCompleted()
    {
        return $this->update([
            'status' => 'completed',
            'delivery_status' => 'delivered',
        ]);
    }

    /**
     * Mark the order as cancelled.
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
