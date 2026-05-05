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
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // For SQLite, we need to recreate the table since it doesn't support dropping columns
            $this->recreateTableForSqlite();
        } else {
            // For MySQL and other databases, use standard alter table
            Schema::table('users', function (Blueprint $table) {
                // Drop columns only if they exist (MySQL/PostgreSQL)
                $table->dropColumn(['name', 'email_verified_at', 'remember_token']);

                $table->string('student_id')->unique()->after('id');
                $table->string('full_name')->after('student_id');
                $table->string('address')->after('full_name');
                $table->string('email')->change();
                $table->enum('status', ['undergraduate', 'alumni'])->default('undergraduate')->after('password');
                $table->boolean('approved')->default(false)->after('status');
                $table->string('role')->default('user')->after('approved');
            });
        }
    }

    /**
     * Recreate table for SQLite compatibility
     */
    private function recreateTableForSqlite(): void
    {
        // Get existing data
        $existingUsers = DB::table('users')->get();

        // Drop and recreate the users table with correct schema
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('full_name');
            $table->string('address');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['undergraduate', 'alumni'])->default('undergraduate');
            $table->string('sport')->nullable();
            $table->string('campus')->nullable();
            $table->string('year_section')->nullable();
            $table->string('document_path')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        // Restore data if any existed
        foreach ($existingUsers as $user) {
            DB::table('users')->insert([
                'id' => $user->id,
                'student_id' => $user->id . '_' . substr(md5($user->email), 0, 8), // Generate student_id
                'full_name' => $user->name ?? $user->email,
                'address' => 'Not provided',
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at ?? null,
                'password' => $user->password,
                'status' => 'undergraduate',
                'remember_token' => $user->remember_token ?? null,
                'created_at' => $user->created_at ?? now(),
                'updated_at' => $user->updated_at ?? now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // For SQLite, recreate with original Laravel schema
            Schema::dropIfExists('users');

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('name')->after('id');
                $table->timestamp('email_verified_at')->nullable()->after('email');
                $table->rememberToken()->after('password');

                $table->dropColumn(['student_id', 'full_name', 'address', 'status']);
            });
        }
    }
};
