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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // pelapor
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->enum('location_type', ['kamar', 'komunal', 'ruang_serbaguna', 'fasilitas_umum', 'other'])->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('status', ['pending', 'received', 'in_progress', 'completed', 'closed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->text('response_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users'); // Building Management or PIC Wing
            $table->timestamp('responded_at')->nullable();
            $table->boolean('is_user_satisfied')->nullable(); // mahasiswa menandai sudah selesai ditanggani
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
