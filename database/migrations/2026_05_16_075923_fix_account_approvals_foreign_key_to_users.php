<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get existing data
        $existing = DB::table('account_approvals')->get();

        // Drop table
        Schema::dropIfExists('account_approvals');

        // Recreate with correct foreign key pointing to users table
        Schema::create('account_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('full_name');
            $table->string('email');
            $table->string('password')->nullable();
            $table->enum('status', ['undergraduate', 'alumni'])->default('undergraduate');
            $table->string('sport')->nullable();
            $table->string('campus')->nullable();
            $table->string('year_section')->nullable();
            $table->string('file_name');
            $table->longText('file_data');
            $table->string('file_type');
            $table->integer('file_size');
            $table->timestamp('request_date')->useCurrent();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approval_date')->nullable();
            $table->unique(['student_id', 'email']);
            $table->timestamps();
        });

        // Restore data
        foreach ($existing as $row) {
            DB::table('account_approvals')->insert((array)$row);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a fix migration, reversing it might not be simple if we want to restore the "broken" FK.
        // But for consistency:
        Schema::table('account_approvals', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            // We can't easily change it back to admins table in SQLite without recreating again.
        });
    }
};
