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
        if (Schema::hasTable('football_matches')) {
            Schema::table('football_matches', function (Blueprint $table) {
                if (!Schema::hasColumn('football_matches', 'stadium_image')) {
                    $table->string('stadium_image')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('football_matches')) {
            Schema::table('football_matches', function (Blueprint $table) {
                if (Schema::hasColumn('football_matches', 'stadium_image')) {
                    $table->dropColumn('stadium_image');
                }
            });
        }
    }
};
