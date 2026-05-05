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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id('achievement_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('athlete_name');
            $table->string('level_of_competition');
            $table->string('performance');
            $table->string('number_of_events')->nullable();
            $table->string('leadership_role')->nullable();
            $table->string('sportsmanship')->nullable();
            $table->string('community_impact')->nullable();
            $table->string('completeness_of_documents')->nullable();
            $table->integer('total_points');
            $table->text('documents')->nullable(); // JSON array of file paths
            $table->timestamp('submission_date')->useCurrent();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
