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
        Schema::create('account_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('full_name');
            $table->string('email');
            $table->enum('status', ['undergraduate', 'alumni'])->default('undergraduate');
            $table->string('file_name');
            $table->text('file_data'); // Store as base64 for SQLite compatibility
            $table->string('file_type');
            $table->integer('file_size');
            $table->timestamp('request_date')->useCurrent();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approval_date')->nullable();
            $table->unique(['student_id', 'email']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_approvals');
    }
};
