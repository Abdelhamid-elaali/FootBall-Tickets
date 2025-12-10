<?php

namespace Database\Seeders;

use App\Models\FootballMatch;
use App\Models\TicketType;
use Illuminate\Database\Seeder;

class MatchSeeder extends Seeder
{
    public function run()
    {
        $matches = [
            [
                'name' => 'Premier League: Manchester United vs Liverpool',
                'home_team' => 'Manchester United',
                'away_team' => 'Liverpool',
                'match_date' => now()->addDays(5),
                'stadium' => 'Old Trafford',
                'stadium_image' => 'stadium-images/old-trafford.jpg',
                'match_status' => 'scheduled',
                'description' => 'A thrilling Premier League match between two historic rivals.',
                'ticket_types' => [
                    ['type' => 'Standard', 'price' => 50.00, 'available_tickets' => 1000],
                    ['type' => 'VIP', 'price' => 75.00, 'available_tickets' => 500],
                    ['type' => 'Premium', 'price' => 100.00, 'available_tickets' => 200],
                ]
            ],
            [
                'name' => 'Premier League: Arsenal vs Chelsea',
                'home_team' => 'Arsenal',
                'away_team' => 'Chelsea',
                'match_date' => now()->addDays(7),
                'stadium' => 'Emirates Stadium',
                'stadium_image' => 'stadium-images/Emirates Stadium.jpg',
                'match_status' => 'scheduled',
                'description' => 'London derby featuring two of the city\'s biggest clubs.',
                'ticket_types' => [
                    ['type' => 'Standard', 'price' => 45.00, 'available_tickets' => 800],
                    ['type' => 'VIP', 'price' => 70.00, 'available_tickets' => 400],
                    ['type' => 'Premium', 'price' => 95.00, 'available_tickets' => 150],
                ]
            ],
            [
                'name' => 'Premier League: Manchester City vs Tottenham',
                'home_team' => 'Manchester City',
                'away_team' => 'Tottenham',
                'match_date' => now()->addDays(10),
                'stadium' => 'Etihad Stadium',
                'stadium_image' => 'stadium-images/Etihad-Stadium.jpg',
                'match_status' => 'scheduled',
                'description' => 'An exciting match between two attacking teams.',
                'ticket_types' => [
                    ['type' => 'Standard', 'price' => 55.00, 'available_tickets' => 900],
                    ['type' => 'VIP', 'price' => 80.00, 'available_tickets' => 450],
                    ['type' => 'Premium', 'price' => 105.00, 'available_tickets' => 180],
                ]
            ],
        ];

        foreach ($matches as $matchData) {
            $ticketTypes = $matchData['ticket_types'];
            unset($matchData['ticket_types']);
            
            $match = FootballMatch::create($matchData);
            
            foreach ($ticketTypes as $ticketType) {
                TicketType::create([
                    'match_id' => $match->id,
                    'type' => $ticketType['type'],
                    'price' => $ticketType['price'],
                    'available_tickets' => $ticketType['available_tickets'],
                ]);
            }
        }
    }
}
