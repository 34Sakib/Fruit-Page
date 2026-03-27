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
        Schema::create('courier_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_charge', 8, 2)->default(0);
            $table->decimal('inside_dhaka_charge', 8, 2)->nullable();
            $table->decimal('outside_dhaka_charge', 8, 2)->nullable();
            $table->integer('delivery_days_inside')->nullable();
            $table->integer('delivery_days_outside')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website')->nullable();
            $table->text('tracking_url_template')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_services');
    }
};
