
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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); 
            $table->string('home_team');
            $table->string('away_team');
            $table->dateTime('match_date');
            $table->string('stadium');
            $table->string('stadium_image')->nullable();
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->enum('ticket_type', ['Standard', 'VIP', 'Premium'])->default('Standard');
            $table->integer('available_tickets')->nullable();
            $table->enum('match_status', ['scheduled', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->text('description')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
