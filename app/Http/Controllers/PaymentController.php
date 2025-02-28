<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $ticketIds = $request->get('tickets', []);
        if (empty($ticketIds)) {
            return redirect()->route('matches.index')->with('error', 'No tickets selected for payment.');
        }

        $tickets = Ticket::whereIn('id', $ticketIds)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with(['match', 'ticketType'])
            ->get();

        if ($tickets->isEmpty()) {
            return redirect()->route('matches.index')->with('error', 'Invalid tickets or tickets already paid.');
        }

        $total = $tickets->sum('price');

        return view('payment.confirm', compact('tickets', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:tickets,id',
            'payment_method' => 'required|in:card,paypal'
        ]);

        $tickets = Ticket::whereIn('id', $request->ticket_ids)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with(['match', 'ticketType'])
            ->get();

        if ($tickets->isEmpty()) {
            return back()->with('error', 'Invalid tickets or tickets already paid.');
        }

        $total = $tickets->sum('price');

        // Redirect to PayPal payment
        return redirect()->route('paypal.create', [
            'ticket_ids' => $request->ticket_ids,
            'total' => $total,
            'payment_method' => $request->payment_method
        ]);
    }

    public function success()
    {
        return redirect()->route('my-tickets')->with('success', 'Payment completed successfully!');
    }

    public function cancel()
    {
        return redirect()->route('my-tickets')->with('error', 'Payment was cancelled.');
    }
}
