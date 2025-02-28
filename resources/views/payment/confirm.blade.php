<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 py-8 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Ticket Details</h3>
                        @foreach($tickets as $ticket)
                            <div class="border-b pb-4 mb-4 last:border-b-0">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Teams</p>
                                        <p class="font-medium">{{ $ticket->match->home_team }} vs {{ $ticket->match->away_team }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Date & Time</p>
                                        <p class="font-medium">{{ $ticket->match->match_date->format('M d, Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Stadium</p>
                                        <p class="font-medium">{{ $ticket->match->stadium }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Ticket Type</p>
                                        <p class="font-medium">{{ $ticket->ticketType->type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Ticket Price</p>
                                        <p class="font-medium">${{ number_format($ticket->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <p class="text-lg font-semibold">Total Amount:</p>
                                <p class="text-2xl font-bold text-green-600">${{ number_format($total, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Choose Payment Method</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- PayPal Credit Card Option -->
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-medium">Credit Card via PayPal</h4>
                                    <div class="flex space-x-2">
                                        <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-6 w-12">
                                        <img src="{{ asset('images/MasterCard.png') }}" alt="Mastercard" class="h-6">
                                    </div>
                                </div>
                                <form action="{{ route('payment.store') }}" method="POST">
                                    @csrf
                                    @foreach($tickets as $ticket)
                                        <input type="hidden" name="ticket_ids[]" value="{{ $ticket->id }}">
                                    @endforeach
                                    <input type="hidden" name="payment_method" value="card">
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2 mt-2 px-4 rounded hover:bg-blue-700 transition">
                                        Pay with Credit Card
                                    </button>
                                </form>
                            </div>

                            <!-- PayPal Direct Option -->
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-medium">PayPal</h4>
                                    <img src="{{ asset('images/Paypal.png') }}" alt="PayPal" class="h-8">
                                </div>
                                <form action="{{ route('payment.store') }}" method="POST">
                                    @csrf
                                    @foreach($tickets as $ticket)
                                        <input type="hidden" name="ticket_ids[]" value="{{ $ticket->id }}">
                                    @endforeach
                                    <input type="hidden" name="payment_method" value="paypal">
                                    <button type="submit" class="w-full bg-[#0070ba] text-white py-2 px-4 rounded hover:bg-[#003087] transition">
                                        Pay with PayPal
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
