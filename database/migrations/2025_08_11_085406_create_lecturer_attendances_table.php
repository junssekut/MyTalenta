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
        Schema::create('lecturer_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->cascadeOnDelete();
            $table->string('lecturer_name');
            $table->string('subject');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['present', 'absent', 'late', 'cancelled'])->default('present');
            $table->text('notes')->nullable();
            $table->text('material_covered')->nullable();
            $table->foreignId('reported_by')->constrained('users'); // sekretaris kelas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_attendances');
    }
};
