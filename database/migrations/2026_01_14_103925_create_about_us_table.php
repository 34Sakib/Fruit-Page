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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_title');
            $table->text('hero_subtitle');
            $table->string('hero_icon')->default('fas fa-leaf');
            
            // Stats Section
            $table->integer('happy_customers')->default(50000);
            $table->integer('deliveries_made')->default(150000);
            $table->integer('local_farms')->default(200);
            $table->integer('years_excellence')->default(8);
            
            // Mission Section
            $table->string('mission_title');
            $table->text('mission_subtitle');
            
            // Features (Mission related)
            $table->string('feature1_title')->default('Sustainable Farming');
            $table->text('feature1_text');
            $table->string('feature1_icon')->default('fas fa-seedling');
            
            $table->string('feature2_title')->default('Health & Wellness');
            $table->text('feature2_text');
            $table->string('feature2_icon')->default('fas fa-heart');
            
            $table->string('feature3_title')->default('Community Support');
            $table->text('feature3_text');
            $table->string('feature3_icon')->default('fas fa-handshake');
            
            // Team Section
            $table->string('team_title')->default('Meet Our Team');
            $table->text('team_subtitle');
            
            // Values Section
            $table->string('values_title')->default('Our Core Values');
            $table->text('values_subtitle');
            
            $table->string('value1_title')->default('Quality First');
            $table->text('value1_text');
            
            $table->string('value2_title')->default('Sustainability');
            $table->text('value2_text');
            
            $table->string('value3_title')->default('Transparency');
            $table->text('value3_text');
            
            // CTA Section
            $table->string('cta_title');
            $table->text('cta_text');
            $table->string('cta_button_text')->default('Start Shopping');
            $table->string('cta_button_url')->default('#');
            $table->string('cta_button_icon')->default('fas fa-shopping-basket');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
