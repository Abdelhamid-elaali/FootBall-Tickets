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
        Schema::table('matches', function (Blueprint $table) {
            // Remove old columns
            $table->dropColumn([
                'ticket_price',
                'available_tickets',
                'ticket_type'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->decimal('ticket_price', 10, 2)->after('stadium');
            $table->integer('available_tickets')->after('ticket_price');
            $table->string('ticket_type')->after('available_tickets');
        });
    }
};
