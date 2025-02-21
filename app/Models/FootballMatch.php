<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Ticket;

class FootballMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'name',
        'home_team',
        'away_team',
        'match_date',
        'stadium',
        'ticket_price',
        'ticket_type',
        'available_tickets',
        'description',
        'match_time',
        'match_status'
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'ticket_price' => 'decimal:2',
        'match_time' => 'datetime'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'match_id');
    }
}
