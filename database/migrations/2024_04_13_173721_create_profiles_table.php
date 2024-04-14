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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('profilename');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->string('phone');
            $table->string('email');
            $table->string('location');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

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











//             if (Schema::hasTable('countries')) {
//                 $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
//             }
//             if (Schema::hasTable('cities')) {
//                 $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
//             }


















