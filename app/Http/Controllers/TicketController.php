<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\FootballMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->tickets()
            ->with(['match', 'payment'])
            ->latest()
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matches,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $match = FootballMatch::findOrFail($request->match_id);

        if ($match->available_tickets < $request->quantity) {
            return back()->with('error', 'Not enough tickets available.');
        }

        $tickets = [];
        for ($i = 0; $i < $request->quantity; $i++) {
            $tickets[] = Ticket::create([
                'user_id' => auth()->id(),
                'match_id' => $match->id,
                'price' => $match->ticket_price,
                'status' => 'pending',
                'ticket_number' => 'TIX-' . Str::random(10),
            ]);
        }

        $match->decrement('available_tickets', $request->quantity);

        // Redirect with success message
        return redirect()->route('my-tickets')->with('success', 'Booking successful! You have booked ' . $request->quantity . ' ticket(s) for ' . $match->home_team . ' vs ' . $match->away_team . '. Check your tickets below.');
    }
}
