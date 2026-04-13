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
            // Upgrade file_data from TEXT (64KB) to LONGTEXT (4GB) 
            // to support base64 encoded images/documents.
            $table->longText('file_data')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_approvals', function (Blueprint $table) {
            $table->text('file_data')->change();
        });
    }
};
