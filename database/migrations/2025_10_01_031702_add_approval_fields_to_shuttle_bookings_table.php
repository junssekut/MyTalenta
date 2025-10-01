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
        Schema::table('shuttle_bookings', function (Blueprint $table) {
            // Drop restrictive unique constraints
            $table->dropUnique(['user_id']);
            $table->dropUnique(['shuttle_route_id']);
            $table->dropUnique(['travel_date']);
            $table->dropUnique(['type']);

            // Update status enum to include approval statuses
            $table->enum('status', ['pending', 'approved', 'rejected', 'confirmed', 'cancelled'])->default('pending')->change();

            // Add approval fields
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');

            // Add proper unique constraint
            $table->unique(['user_id', 'shuttle_route_id', 'travel_date', 'type'], 'unique_shuttle_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shuttle_bookings', function (Blueprint $table) {
            // Remove approval fields
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['approved_by', 'approved_at', 'approval_notes', 'approval_status']);

            // Drop the new unique constraint
            $table->dropUnique('unique_shuttle_booking');

            // Revert status enum
            $table->enum('status', ['confirmed', 'cancelled'])->default('confirmed')->change();

            // Restore old unique constraints (though they're problematic)
            $table->unique('user_id');
            $table->unique('shuttle_route_id');
            $table->unique('travel_date');
            $table->unique('type');
        });
    }
};
