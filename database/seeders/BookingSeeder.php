<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Payment;
use App\Models\User;
use App\Models\FootballMatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run()
    {
        // Get all regular users
        $users = User::where('role', 'user')->get();
        
        // Get all matches
        $matches = FootballMatch::with('ticketTypes')->get();

        if ($users->isEmpty() || $matches->isEmpty()) {
            $this->command->info('No users or matches found. Skipping booking seeder.');
            return;
        }

        $bookingData = [
            // User 1 bookings
            [
                'user_id' => $users->first()->id,
                'match_id' => $matches[0]->id,
                'ticket_type_id' => $matches[0]->ticketTypes[0]->id, // Standard
                'quantity' => 2,
                'payment_method' => 'credit_card',
                'status' => 'confirmed',
            ],
            [
                'user_id' => $users->first()->id,
                'match_id' => $matches[1]->id,
                'ticket_type_id' => $matches[1]->ticketTypes[1]->id, // VIP
                'quantity' => 1,
                'payment_method' => 'paypal',
                'status' => 'confirmed',
            ],
            [
                'user_id' => $users->first()->id,
                'match_id' => $matches[2]->id,
                'ticket_type_id' => $matches[2]->ticketTypes[2]->id, // Premium
                'quantity' => 1,
                'payment_method' => 'credit_card',
                'status' => 'pending',
            ],
        ];

        // If there are more users, add bookings for them
        if ($users->count() > 1) {
            $bookingData[] = [
                'user_id' => $users[1]->id,
                'match_id' => $matches[0]->id,
                'ticket_type_id' => $matches[0]->ticketTypes[1]->id, // VIP
                'quantity' => 3,
                'payment_method' => 'credit_card',
                'status' => 'confirmed',
            ];
        }

        // Create tickets and payments
        foreach ($bookingData as $booking) {
            $ticketType = $matches->find($booking['match_id'])->ticketTypes->find($booking['ticket_type_id']);
            $totalAmount = $ticketType->price * $booking['quantity'];

            // Create tickets
            $tickets = [];
            for ($i = 0; $i < $booking['quantity']; $i++) {
                $ticket = Ticket::create([
                    'user_id' => $booking['user_id'],
                    'match_id' => $booking['match_id'],
                    'ticket_type_id' => $booking['ticket_type_id'],
                    'seat_number' => 'A' . ($i + 1),
                    'price' => $ticketType->price,
                    'status' => $booking['status'],
                    'ticket_number' => Str::random(10),
                ]);
                $tickets[] = $ticket;

                // Create payment for each ticket
                if ($booking['status'] === 'confirmed') {
                    Payment::create([
                        'user_id' => $booking['user_id'],
                        'ticket_id' => $ticket->id,
                        'amount' => $ticketType->price,
                        'payment_method' => $booking['payment_method'],
                        'transaction_id' => 'TXN-' . Str::random(12),
                        'status' => 'completed',
                    ]);
                } else {
                    // Pending tickets have pending payments
                    Payment::create([
                        'user_id' => $booking['user_id'],
                        'ticket_id' => $ticket->id,
                        'amount' => $ticketType->price,
                        'payment_method' => $booking['payment_method'],
                        'transaction_id' => null,
                        'status' => 'pending',
                    ]);
                }
            }

            // Decrement available tickets
            $ticketType->decrement('available_tickets', $booking['quantity']);
        }

        $this->command->info('Booking seeder completed successfully!');
    }
}
