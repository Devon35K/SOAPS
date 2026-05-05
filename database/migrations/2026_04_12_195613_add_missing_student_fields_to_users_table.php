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
            if (!Schema::hasColumn('users', 'sport')) {
                $table->string('sport')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'campus')) {
                $table->string('campus')->nullable()->after('sport');
            }
            if (!Schema::hasColumn('users', 'year_section')) {
                $table->string('year_section')->nullable()->after('campus');
            }
            if (!Schema::hasColumn('users', 'document_path')) {
                $table->string('document_path')->nullable()->after('year_section');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sport', 'campus', 'year_section', 'document_path']);
        });
    }
};
