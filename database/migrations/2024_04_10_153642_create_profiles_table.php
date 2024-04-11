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
        Schema::create('profiles', function (Blueprint $table) {

            $table->id();
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('profilename', 255);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->string('phone', 20);
            $table->string('email', 255);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Add foreign key constraint conditionally based on table existence
            if (Schema::hasTable('countries')) {
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            }
            if (Schema::hasTable('cities')) {
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
