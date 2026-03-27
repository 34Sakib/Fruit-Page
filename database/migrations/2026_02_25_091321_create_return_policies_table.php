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
        Schema::create('return_policies', function (Blueprint $table) {
            $table->id();

            // Hero Section
            $table->string('hero_title')->default('Return Policy');
            $table->text('hero_subtitle')->nullable();

            // Introduction
            $table->text('introduction')->nullable();

            // Return Eligibility
            $table->text('fresh_produce_eligibility')->nullable();
            $table->text('dairy_perishables_eligibility')->nullable();
            $table->text('packaged_foods_eligibility')->nullable();
            $table->text('non_returnable_items')->nullable();

            // Return Process
            $table->text('contact_customer_service')->nullable();
            $table->text('documentation_required')->nullable();
            $table->text('return_approval')->nullable();
            $table->text('product_return_step')->nullable();

            // Refund Options
            $table->text('full_refund')->nullable();
            $table->text('store_credit')->nullable();
            $table->text('product_exchange')->nullable();

            // Special Circumstances
            $table->text('wrong_item_delivered')->nullable();
            $table->text('quality_issues')->nullable();
            $table->text('delivery_delays')->nullable();

            // Return Timeframes - Individual fields for each category
            $table->string('fresh_produce_timeframe', 50)->nullable();
            $table->string('fresh_produce_conditions')->nullable();
            $table->string('dairy_timeframe', 50)->nullable();
            $table->string('dairy_conditions')->nullable();
            $table->string('packaged_foods_timeframe', 50)->nullable();
            $table->string('packaged_foods_conditions')->nullable();
            $table->string('wrong_items_timeframe', 50)->nullable();
            $table->string('wrong_items_conditions')->nullable();

            // Customer Responsibilities
            $table->text('product_inspection')->nullable();
            $table->text('return_preparation')->nullable();
            $table->text('communication')->nullable();

            // Return Support
            $table->string('return_hotline')->nullable();
            $table->string('return_email')->nullable();
            $table->string('support_hours')->nullable();
            $table->string('live_chat')->nullable();
            $table->string('whatsapp')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_policies');
    }
};
