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
        Schema::create('shuttle_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shuttle_route_id')->constrained()->cascadeOnDelete();
            $table->date('travel_date');
            $table->enum('type', ['pulang', 'kembali']); // shuttle pulang atau shuttle kembali
            $table->text('notes')->nullable();
            $table->enum('status', ['confirmed', 'cancelled'])->default('confirmed');
            $table->timestamp('booking_deadline')->nullable(); // deadline pemesanan
            $table->timestamps();
            
            $table->unique(['user_id', 'shuttle_route_id', 'travel_date', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shuttle_bookings');
    }
};
