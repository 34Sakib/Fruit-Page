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
        Schema::create('shipping_policies', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->text('hero_subtitle');

            // Our Shipping Commitment
            $table->text('introduction')->nullable();

            // Delivery Areas
            $table->text('current_coverage')->nullable();
            $table->text('expansion_plans')->nullable();

            // Delivery Timeframes
            $table->text('standard_delivery_time')->nullable();
            $table->text('express_delivery_time')->nullable();
            $table->text('scheduled_delivery')->nullable();

            // Shipping Charges
            $table->text('standard_delivery_rates')->nullable();
            $table->text('additional_services')->nullable();

            // Order Processing
            $table->text('order_confirmation')->nullable();
            $table->text('quality_assurance')->nullable();
            $table->text('dispatch_process')->nullable();

            // Packaging Standards
            $table->text('fresh_produce_packaging')->nullable();
            $table->text('dairy_perishables_packaging')->nullable();
            $table->text('packaged_goods_packaging')->nullable();

            // Delivery Process
            $table->text('before_delivery')->nullable();
            $table->text('during_delivery')->nullable();
            $table->text('after_delivery')->nullable();

            // Special Circumstances
            $table->text('weather_conditions')->nullable();
            $table->text('product_unavailability')->nullable();
            $table->text('failed_delivery_attempts')->nullable();

            // International Shipping
            $table->text('international_shipping')->nullable();

            // Shipping Support
            $table->string('shipping_hotline')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('support_hours')->nullable();
            $table->string('live_chat')->nullable();

            // Legacy fields for backward compatibility
            $table->text('delivery_areas')->nullable();
            $table->text('delivery_time')->nullable();
            $table->text('delivery_charges')->nullable();
            $table->text('order_processing')->nullable();
            $table->text('packaging_standards')->nullable();
            $table->text('delivery_process')->nullable();
            $table->text('special_circumstances')->nullable();
            $table->text('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_address')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_policies');
    }
};
