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
            $table->dropColumn('name');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('rememberToken');
            
            $table->string('student_id')->unique()->after('id');
            $table->string('full_name')->after('student_id');
            $table->string('address')->after('full_name');
            $table->string('email')->unique()->change();
            $table->enum('status', ['undergraduate', 'alumni'])->default('undergraduate')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->rememberToken()->after('password');
            
            $table->dropColumn('student_id');
            $table->dropColumn('full_name');
            $table->dropColumn('address');
            $table->dropColumn('status');
        });
    }
};
