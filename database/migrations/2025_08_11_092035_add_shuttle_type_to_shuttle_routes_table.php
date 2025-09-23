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
        Schema::table('shuttle_routes', function (Blueprint $table) {
            $table->enum('shuttle_type', ['pulang', 'kembali'])->after('destination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shuttle_routes', function (Blueprint $table) {
            $table->dropColumn('shuttle_type');
        });
    }
};
