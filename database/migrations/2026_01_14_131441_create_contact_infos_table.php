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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            
            // Header Section
            $table->string('header_title')->default('Get in Touch With Us');
            $table->text('header_subtitle')->nullable();
            $table->string('header_icon')->default('fas fa-headset');
            
            // Contact Cards
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('email_hours')->nullable();
            $table->string('phone_hours')->nullable();
            
            // Map Section
            $table->string('map_embed_url')->nullable();
            $table->text('map_address')->nullable();
            
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
