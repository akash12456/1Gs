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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('language')->nullable();
            $table->string('driver_license')->nullable();
            $table->date('DOB')->nullable();
            $table->string('license_plate_number')->nullable();
            $table->string('profilephoto')->nullable();
            $table->string('licenseImage')->nullable();
            $table->string('RCimage')->nullable();
            $table->string('insurance_image')->nullable();
            $table->string('permit_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
