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
        Schema::create('subscription_details', function (Blueprint $table) {
            $table->id(); // Primary key 'id'
            $table->string('nickname')->nullable(); // Can store subscription nickname
            $table->string('type')->nullable(); // Type of subscription
            $table->string('image')->nullable(); // URL or path to image
            $table->decimal('unit_amount', 10, 2); // Price of the subscription
            $table->string('currency', 3); // Currency code (e.g., USD, EUR)
            $table->string('interval'); // Billing interval (e.g., month, year)
            $table->string('price_id'); // Stripe price ID
            $table->string('product_id'); // Stripe product ID
            $table->integer('interval_count')->default(1); // Number of intervals between billing
            $table->text('description')->nullable(); // Subscription description
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_details');
    }
};
