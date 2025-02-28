<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FootballMatch;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'name',
        'type',
        'price',
        'available_tickets',
    ];

    public function match()
    {
        return $this->belongsTo(FootballMatch::class);
    }
}
