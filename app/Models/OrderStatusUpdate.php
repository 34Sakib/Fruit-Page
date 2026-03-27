<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class OrderStatusUpdate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'previous_status',
        'new_status',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order that owns the status update.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user who made the status update.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the label for the previous status.
     */
    public function getPreviousStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->previous_status));
    }

    /**
     * Get the label for the new status.
     */
    public function getNewStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->new_status));
    }
}
