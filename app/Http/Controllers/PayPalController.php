<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:tickets,id',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:card,paypal'
        ]);

        $tickets = Ticket::whereIn('id', $request->ticket_ids)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        if ($tickets->isEmpty()) {
            return back()->with('error', 'Invalid tickets or tickets already paid.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($request->total, 2, '.', '')
                    ],
                    "description" => "Football Match Tickets"
                ]],
                "application_context" => [
                    "cancel_url" => route('paypal.cancel'),
                    "return_url" => route('paypal.success')
                ]
            ]);

            if (isset($order['id']) && $order['id']) {
                session(['paypal_order_id' => $order['id']]);
                session(['ticket_ids' => $request->ticket_ids]);
                dd($order['links']);
                return redirect($order['links'][1]['href']);
            }

            return back()->with('error', 'Something went wrong with PayPal.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function capturePayment(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $order = $provider->capturePaymentOrder($request->token);

            if ($order['status'] === "COMPLETED") {
                $ticketIds = session('ticket_ids', []);
                
                if (empty($ticketIds)) {
                    throw new \Exception('No tickets found in session.');
                }

                \DB::beginTransaction();

                try {
                    $tickets = Ticket::whereIn('id', $ticketIds)
                        ->where('user_id', auth()->id())
                        ->where('status', 'pending')
                        ->get();

                    if ($tickets->isEmpty()) {
                        throw new \Exception('No valid tickets found.');
                    }

                    // Create payment record
                    $payment = Payment::create([
                        'user_id' => auth()->id(),
                        'amount' => $tickets->sum('price'),
                        'payment_method' => 'paypal',
                        'transaction_id' => $order['id'],
                        'status' => 'completed'
                    ]);

                    // Update tickets
                    foreach ($tickets as $ticket) {
                        $ticket->update([
                            'status' => 'paid',
                            'payment_id' => $payment->id
                        ]);
                    }

                    \DB::commit();
                    session()->forget(['paypal_order_id', 'ticket_ids']);

                    return redirect()->route('my-tickets')
                        ->with('success', 'Payment completed successfully! Your tickets have been confirmed.');

                } catch (\Exception $e) {
                    \DB::rollBack();
                    return redirect()->route('payment.confirm')
                        ->with('error', 'Error processing payment confirmation: ' . $e->getMessage());
                }
            }

            return redirect()->route('payment.confirm')
                ->with('error', 'Payment was not completed.');

        } catch (\Exception $e) {
            return redirect()->route('payment.confirm')
                ->with('error', 'Error capturing PayPal payment: ' . $e->getMessage());
        }
    }

    public function cancelPayment()
    {
        session()->forget(['paypal_order_id', 'ticket_ids']);
        return redirect()->route('my-tickets')
            ->with('error', 'Payment was cancelled.');
    }
}
