<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\FootballMatch;
use App\Models\Payment;
use App\Models\TicketType;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'match_id',
        'ticket_type_id',
        'seat_number',
        'price',
        'status',
        'ticket_number'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function match()
    {
        return $this->belongsTo(FootballMatch::class, 'match_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
