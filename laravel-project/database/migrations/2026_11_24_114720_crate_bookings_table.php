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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('room_id');
            $table->integer('creator_id');
            $table->timestamp('inTime')->nullable();
            $table->timestamp('outTime')->nullable();
            $table->string('status');
            $table->string('result')->nullable();
        });

        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique()->nullable();
        });

        Schema::create('guestsList', function (Blueprint $table) {
            $table->integer('booking_id');
            $table->integer('guest_id');            
        });

        Schema::create('usersList', function (Blueprint $table) {
            $table->integer('booking_id');
            $table->integer('user_id');
        });
        
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('guests');
        Schema::dropIfExists('guestsList');
        Schema::dropIfExists('usersList');
    }
};
