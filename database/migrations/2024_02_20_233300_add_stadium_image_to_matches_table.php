<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Remove this migration since we've added stadium_image to the create_matches_table migration
    }

    public function down()
    {
        // No need to do anything here
    }
};
