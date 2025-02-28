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

    public function create(FootballMatch $match)
    {
        // Load ticket types with the match
        $match->load('ticketTypes');

        // Check if there are any available tickets
        $totalAvailableTickets = $match->ticketTypes->sum('available_tickets');
        if ($totalAvailableTickets <= 0) {
            return back()->with('error', 'Sorry, this match is sold out.');
        }

        return view('tickets.create', compact('match'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:football_matches,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:0',
        ]);

        $match = FootballMatch::with('ticketTypes')->findOrFail($request->match_id);
        $totalAmount = 0;
        $tickets = [];

        // Check if any tickets were selected
        if (array_sum($request->quantities) === 0) {
            return back()->with('error', 'Please select at least one ticket.');
        }

        \DB::beginTransaction();

        try {
            foreach ($request->quantities as $typeId => $quantity) {
                if ($quantity > 0) {
                    $ticketType = $match->ticketTypes->find($typeId);
                    
                    if (!$ticketType) {
                        throw new \Exception('Invalid ticket type.');
                    }

                    if ($ticketType->available_tickets < $quantity) {
                        throw new \Exception("Not enough {$ticketType->name} tickets available.");
                    }

                    // Create tickets
                    for ($i = 0; $i < $quantity; $i++) {
                        $ticket = Ticket::create([
                            'user_id' => auth()->id(),
                            'match_id' => $match->id,
                            'ticket_type_id' => $typeId,
                            'ticket_number' => Str::random(10),
                            'price' => $ticketType->price,
                            'status' => 'pending',
                            'ticket_type_id' => $typeId
                        ]);
                        $tickets[] = $ticket;
                        $totalAmount += $ticketType->price;
                    }

                    // Update available tickets
                    $ticketType->decrement('available_tickets', $quantity);
                }
            }

            \DB::commit();

            // Redirect to payment confirmation page with all ticket IDs
            return redirect()->route('payment.confirm', [
                'tickets' => array_map(fn($ticket) => $ticket->id, $tickets)
            ])->with('success', 'Tickets reserved successfully. Please complete your payment.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
