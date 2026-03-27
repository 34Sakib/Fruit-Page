<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('special_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            
            // Customer Information
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->boolean('is_inside_dhaka');
            
            // Product Information
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('product_name')->nullable();
            $table->decimal('quantity', 8, 2)->nullable(); // Final quantity after negotiation
            
            // Customer Requirements
            $table->text('notes');
            
            // Pricing (Negotiable)
            $table->decimal('final_price', 10, 2)->nullable();
            
            // Delivery Charges
            $table->decimal('delivery_charge', 10, 2);
            
            // Invoice and Tracking
            $table->timestamp('invoice_sent_at')->nullable();
            $table->string('tracking_number')->nullable();
            
            // Order Status
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            
            // Courier Service
            $table->foreignId('courier_service_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('courier_charge', 10, 2)->nullable();
            $table->text('courier_tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_orders');
    }
};
