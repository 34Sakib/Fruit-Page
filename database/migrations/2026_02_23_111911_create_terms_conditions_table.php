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
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->text('hero_subtitle');
            $table->text('introduction')->nullable();
            $table->text('definitions')->nullable();
            $table->text('acceptance_of_terms')->nullable();
            $table->text('registration')->nullable();
            $table->text('account_termination')->nullable();
            $table->text('product_information')->nullable();
            $table->text('order_processing')->nullable();
            $table->text('pricing')->nullable();
            $table->text('payment_methods')->nullable();
            $table->text('delivery_areas')->nullable();
            $table->text('delivery_time')->nullable();
            $table->text('delivery_charges')->nullable();
            $table->text('return_policy')->nullable();
            $table->text('refund_process')->nullable();
            $table->text('intellectual_property')->nullable();
            $table->text('user_conduct')->nullable();
            $table->text('limitation_of_liability')->nullable();
            $table->text('termination')->nullable();
            $table->text('changes_to_terms')->nullable();
            $table->text('contact_email');
            $table->string('contact_phone');
            $table->string('contact_address');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_conditions');
    }
};
