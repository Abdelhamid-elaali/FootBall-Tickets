<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Ticket;
use App\Models\TicketType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First add the column without constraints
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('ticket_type_id')->after('match_id')->nullable();
        });

        // Create a default ticket type for each match if none exists
        $tickets = Ticket::all();
        foreach ($tickets as $ticket) {
            $ticketType = TicketType::where('match_id', $ticket->match_id)->first();
            
            if (!$ticketType) {
                $ticketType = TicketType::create([
                    'match_id' => $ticket->match_id,
                    'name' => 'Standard',
                    'type' => 'Standard',
                    'price' => $ticket->price,
                    'available_tickets' => 100
                ]);
            }
            
            $ticket->update(['ticket_type_id' => $ticketType->id]);
        }

        // Now add the foreign key constraint
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('ticket_type_id')
                  ->references('id')
                  ->on('ticket_types')
                  ->onDelete('cascade');
                  
            // Make the column required now that we have populated it
            $table->foreignId('ticket_type_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['ticket_type_id']);
            $table->dropColumn('ticket_type_id');
        });
    }
};
