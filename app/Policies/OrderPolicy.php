<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return false; // Prevent order deletion
    }

    /**
     * Determine whether the user can cancel the order.
     */
    public function cancel(User $user, Order $order): bool
    {
        // Only allow cancellation if:
        // 1. The user owns the order
        // 2. The order is in a cancelable state
        return $user->id === $order->user_id && 
               in_array($order->status, ['pending', 'processing', 'shipped']);
    }

    /**
     * Determine whether the user can view the order invoice.
     */
    public function viewInvoice(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }
}
