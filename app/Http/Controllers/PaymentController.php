<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $ticketIds = $request->query('tickets', []);
        $total = $request->query('total', 0);

        // Get tickets with their match and type information
        $tickets = Ticket::with(['match', 'ticketType'])
            ->whereIn('id', $ticketIds)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        if ($tickets->isEmpty()) {
            return redirect()->route('matches.index')
                ->with('error', 'No valid tickets found for payment.');
        }

        return view('payment.create', compact('tickets', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:tickets,id',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        // Get tickets and calculate total
        $tickets = Ticket::whereIn('id', $request->ticket_ids)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        if ($tickets->isEmpty()) {
            return back()->with('error', 'No valid tickets found for payment.');
        }

        $totalAmount = $tickets->sum('price');

        // Handle PayPal payment
        if ($request->payment_method === 'paypal') {
            return $this->initiatePayPalPayment($tickets, $totalAmount);
        }

        // Handle Credit Card payment
        return $this->processCreditCardPayment($request, $tickets, $totalAmount);
    }

    protected function initiatePayPalPayment($tickets, $totalAmount)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "GBP",
                    "value" => number_format($totalAmount, 2, '.', '')
                ],
                "description" => "Football Match Tickets Purchase"
            ]],
            "application_context" => [
                "cancel_url" => route('payment.cancel'),
                "return_url" => route('payment.success')
            ]
        ]);

        if (!empty($order['id'])) {
            // Store PayPal order ID in session
            session(['paypal_order_id' => $order['id']]);
            session(['ticket_ids' => $tickets->pluck('id')->toArray()]);

            // Redirect to PayPal
            return redirect($order['links'][1]['href']);
        }

        return back()->with('error', 'Error processing PayPal payment.');
    }

    protected function processCreditCardPayment($request, $tickets, $totalAmount)
    {
        $request->validate([
            'card_number' => 'required',
            'expiry_date' => 'required',
            'cvv' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Create payment record
            $payment = Payment::create([
                'user_id' => auth()->id(),
                'amount' => $totalAmount,
                'payment_method' => 'credit_card',
                'status' => 'completed',
                'transaction_id' => 'CC-' . uniqid(),
            ]);

            // Update tickets status
            foreach ($tickets as $ticket) {
                $ticket->update([
                    'status' => 'paid',
                    'payment_id' => $payment->id
                ]);
            }

            DB::commit();

            return redirect()->route('my-tickets')
                ->with('success', 'Payment successful! Your tickets have been confirmed.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error processing credit card payment.');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $order = $provider->capturePaymentOrder($request->token);

        if ($order['status'] === 'COMPLETED') {
            DB::beginTransaction();

            try {
                $ticketIds = session('ticket_ids', []);
                $tickets = Ticket::whereIn('id', $ticketIds)
                    ->where('user_id', auth()->id())
                    ->where('status', 'pending')
                    ->get();

                // Create payment record
                $payment = Payment::create([
                    'user_id' => auth()->id(),
                    'amount' => $tickets->sum('price'),
                    'payment_method' => 'paypal',
                    'status' => 'completed',
                    'transaction_id' => $order['id'],
                ]);

                // Update tickets status
                foreach ($tickets as $ticket) {
                    $ticket->update([
                        'status' => 'paid',
                        'payment_id' => $payment->id
                    ]);
                }

                DB::commit();
                session()->forget(['paypal_order_id', 'ticket_ids']);

                return redirect()->route('my-tickets')
                    ->with('success', 'PayPal payment successful! Your tickets have been confirmed.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('payment.create')
                    ->with('error', 'Error processing PayPal payment confirmation.');
            }
        }

        return redirect()->route('payment.create')
            ->with('error', 'PayPal payment was not completed.');
    }

    public function cancel()
    {
        return redirect()->route('payment.create')
            ->with('error', 'PayPal payment was cancelled.');
    }
}
