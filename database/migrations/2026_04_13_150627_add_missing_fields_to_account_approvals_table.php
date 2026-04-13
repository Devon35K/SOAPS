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
        Schema::table('account_approvals', function (Blueprint $table) {
            $table->string('password')->after('email');
            $table->string('sport')->nullable()->after('status');
            $table->string('campus')->nullable()->after('sport');
            $table->string('year_section')->nullable()->after('campus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_approvals', function (Blueprint $table) {
            $table->dropColumn(['password', 'sport', 'campus', 'year_section']);
        });
    }
};
