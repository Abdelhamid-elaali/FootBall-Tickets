<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove this migration since we've added role to the create_users_table migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to do anything here
    }
}
