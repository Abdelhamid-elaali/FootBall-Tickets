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
        // Remove this migration since we've added match_status to the create_matches_table migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to do anything here
    }
};
