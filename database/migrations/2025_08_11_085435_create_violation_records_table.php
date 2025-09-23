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
        Schema::create('violation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // mahasiswa yang melanggar
            $table->string('violation_type');
            $table->text('description');
            $table->date('violation_date');
            $table->enum('severity', ['minor', 'moderate', 'major', 'severe'])->default('minor');
            $table->text('action_taken')->nullable();
            $table->foreignId('recorded_by')->constrained('users'); // PIC yang mencatat
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violation_records');
    }
};
