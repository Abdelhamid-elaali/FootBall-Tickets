<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'football_matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'home_team',
        'away_team',
        'match_date',
        'stadium',
        'stadium_image',
        'ticket_price',
        'ticket_type',
        'available_tickets',
        'match_status',
        'description'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'match_date' => 'datetime',
        'ticket_price' => 'decimal:2'
    ];

    /**
     * Get all tickets for this match.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
