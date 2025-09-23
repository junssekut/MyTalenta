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
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->unique()->nullable()->after('id');
            $table->string('card_id', 12)->unique()->nullable()->after('student_id');
            $table->foreignId('role_id')->nullable()->constrained()->after('email');
            $table->foreignId('batch_id')->nullable()->constrained()->after('role_id');
            $table->string('phone')->nullable()->after('email_verified_at');
            $table->text('address')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female'])->nullable()->after('address');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('emergency_contact_name')->nullable()->after('date_of_birth');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->boolean('is_active')->default(true)->after('emergency_contact_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['batch_id']);
            $table->dropColumn([
                'student_id',
                'card_id',
                'role_id',
                'batch_id',
                'phone',
                'address',
                'gender',
                'date_of_birth',
                'emergency_contact_name',
                'emergency_contact_phone',
                'is_active'
            ]);
        });
    }
};
