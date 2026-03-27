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
        Schema::create('privacy_policies', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Privacy Policy');
            $table->text('hero_subtitle')->default('Your privacy is important to us. This policy explains how we collect, use, and protect your information.');
            $table->text('introduction')->nullable();
            $table->text('personal_info')->nullable();
            $table->text('auto_collected_info')->nullable();
            $table->text('information_usage')->nullable();
            $table->text('data_sharing')->nullable();
            $table->text('data_security')->nullable();
            $table->text('cookies_tracking')->nullable();
            $table->text('privacy_rights')->nullable();
            $table->text('third_party_links')->nullable();
            $table->text('children_privacy')->nullable();
            $table->text('policy_changes')->nullable();
            $table->string('contact_email')->default('privacy@fruitmart.com');
            $table->string('contact_phone')->default('+8801641555173');
            $table->string('contact_address')->default('Kuril, Dhaka, Bangladesh');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy_policies');
    }
};
