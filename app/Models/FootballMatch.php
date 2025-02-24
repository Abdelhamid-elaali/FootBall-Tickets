<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Ticket;
use App\Models\TicketType;

class FootballMatch extends Model
{
    use HasFactory;

    protected $table = 'football_matches';

    protected $fillable = [
        'name',
        'home_team',
        'away_team',
        'match_date',
        'match_time',
        'stadium',
        'stadium_image',
        'description',
        'match_status',
        'ticket_price',
        'available_tickets',
        'ticket_type'
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'match_time' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'match_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'match_id');
    }
}
