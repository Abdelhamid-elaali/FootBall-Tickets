<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-16">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Payment Details</h2>

                    <!-- Order Summary -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                        
                        <!-- Tickets List -->
                        <div class="space-y-4">
                            @foreach($tickets->groupBy('match_id') as $matchTickets)
                                @php
                                    $match = $matchTickets->first()->match;
                                    $ticketsByType = $matchTickets->groupBy('ticket_type_id');
                                @endphp
                                
                                <div class="border-b pb-4">
                                    <h4 class="font-semibold text-lg mb-2">{{ $match->home_team }} vs {{ $match->away_team }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $match->match_date->format('D, M d, Y h:i A') }}</p>
                                    <p class="text-gray-600 text-sm mb-2">{{ $match->stadium }}</p>
                                    
                                    <!-- Ticket Types -->
                                    @foreach($ticketsByType as $typeId => $typeTickets)
                                        @php
                                            $ticketType = $typeTickets->first()->ticketType;
                                            $quantity = $typeTickets->count();
                                            $subtotal = $quantity * $ticketType->price;
                                        @endphp
                                        <div class="flex justify-between items-center py-2">
                                            <div>
                                                <p class="font-medium">{{ $ticketType->name }}</p>
                                                <p class="text-sm text-gray-600">£{{ number_format($ticketType->price, 2) }} × {{ $quantity }}</p>
                                            </div>
                                            <p class="font-medium">£{{ number_format($subtotal, 2) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="mt-6 pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <h4 class="text-lg font-semibold">Total Amount</h4>
                                <p class="text-2xl font-bold text-green-600">£{{ number_format($total, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('payment.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @foreach($tickets as $ticket)
                            <input type="hidden" name="ticket_ids[]" value="{{ $ticket->id }}">
                        @endforeach

                        <!-- Payment Method Selection -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4">Select Payment Method</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Credit Card Option -->
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                                    <input type="radio" name="payment_method" value="credit_card" class="absolute top-4 right-4" checked>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex space-x-1">
                                                <svg class="h-8 w-auto text-blue-600" viewBox="0 0 36 24" fill="none">
                                                    <rect x="0.5" y="0.5" width="35" height="23" rx="3.5" fill="white" stroke="#CBD5E0"/>
                                                    <path d="M11 7H25V17H11V7Z" fill="#1A202C"/>
                                                </svg>
                                                <svg class="h-8 w-auto text-red-600" viewBox="0 0 36 24" fill="none">
                                                    <rect x="0.5" y="0.5" width="35" height="23" rx="3.5" fill="white" stroke="#CBD5E0"/>
                                                    <circle cx="18" cy="12" r="6" fill="#F56565" fill-opacity="0.8"/>
                                                    <circle cx="14" cy="12" r="6" fill="#E53E3E" fill-opacity="0.8"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold">Credit Card</h4>
                                            <p class="text-sm text-gray-500">Pay with Visa or Mastercard</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- PayPal Option -->
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                                    <input type="radio" name="payment_method" value="paypal" class="absolute top-4 right-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-auto" viewBox="0 0 101 32" fill="none">
                                                <path d="M12.9 4.1c-0.4-0.4-0.9-0.6-1.5-0.6h-8.5c-0.6 0-1.1 0.4-1.2 1l-3.5 22.1c-0.1 0.4 0.2 0.8 0.6 0.8h4.9c0.6 0 1.1-0.4 1.2-1l0.9-5.8c0.1-0.6 0.6-1 1.2-1h2.7c5.7 0 9-2.8 9.9-8.2 0.4-2.4 0-4.2-1-5.5-1-1.2-2.5-1.8-4.7-1.8zM13.6 12.5c-0.5 3.1-2.9 3.1-5.2 3.1h-1.3l0.9-5.8c0.1-0.3 0.3-0.5 0.6-0.5h0.6c1.6 0 3.1 0 3.9 0.9 0.4 0.6 0.6 1.4 0.5 2.3z" fill="#003087"/>
                                                <path d="M35.7 11.9h-4.3c-0.3 0-0.6 0.2-0.6 0.5l-0.2 1-0.3-0.4c-0.8-1.2-2.6-1.6-4.4-1.6-4.1 0-7.6 3.1-8.3 7.5-0.4 2.2 0.1 4.2 1.4 5.7 1.1 1.3 2.7 1.9 4.6 1.9 3.3 0 5.1-2.1 5.1-2.1l-0.2 1c-0.1 0.4 0.2 0.8 0.6 0.8h3.9c0.6 0 1.1-0.4 1.2-1l2.2-14.1c0.1-0.4-0.2-0.8-0.6-0.8zM30.1 19.3c-0.4 2.2-2.1 3.7-4.4 3.7-1.1 0-2-0.4-2.6-1.1-0.6-0.7-0.8-1.7-0.6-2.9 0.3-2.2 2.1-3.7 4.3-3.7 1.1 0 2 0.4 2.6 1.1 0.6 0.7 0.8 1.8 0.6 2.9z" fill="#003087"/>
                                                <path d="M55.3 11.9h-4.3c-0.4 0-0.8 0.2-1 0.5l-5.6 8.3-2.4-8c-0.2-0.5-0.6-0.8-1.1-0.8h-4.2c-0.5 0-0.8 0.5-0.7 0.9l4.5 13.1-4.2 5.9c-0.3 0.5 0 1.1 0.5 1.1h4.3c0.4 0 0.8-0.2 1-0.5l13.5-19.5c0.3-0.4 0-1-0.5-1z" fill="#003087"/>
                                                <path d="M67.3 4.1c-0.4-0.4-0.9-0.6-1.5-0.6h-8.5c-0.6 0-1.1 0.4-1.2 1l-3.5 22.1c-0.1 0.4 0.2 0.8 0.6 0.8h4.3c0.5 0 0.9-0.3 1-0.8l1-6c0.1-0.6 0.6-1 1.2-1h2.7c5.7 0 9-2.8 9.9-8.2 0.4-2.4 0-4.2-1-5.5-1-1.2-2.5-1.8-4.7-1.8zM68 12.5c-0.5 3.1-2.9 3.1-5.2 3.1h-1.3l0.9-5.8c0.1-0.3 0.3-0.5 0.6-0.5h0.6c1.6 0 3.1 0 3.9 0.9 0.4 0.6 0.6 1.4 0.5 2.3z" fill="#009CDE"/>
                                                <path d="M90.1 11.9h-4.3c-0.3 0-0.6 0.2-0.6 0.5l-0.2 1-0.3-0.4c-0.8-1.2-2.6-1.6-4.4-1.6-4.1 0-7.6 3.1-8.3 7.5-0.4 2.2 0.1 4.2 1.4 5.7 1.1 1.3 2.7 1.9 4.6 1.9 3.3 0 5.1-2.1 5.1-2.1l-0.2 1c-0.1 0.4 0.2 0.8 0.6 0.8h3.9c0.6 0 1.1-0.4 1.2-1l2.2-14.1c0.1-0.4-0.2-0.8-0.6-0.8zM84.5 19.3c-0.4 2.2-2.1 3.7-4.4 3.7-1.1 0-2-0.4-2.6-1.1-0.6-0.7-0.8-1.7-0.6-2.9 0.3-2.2 2.1-3.7 4.3-3.7 1.1 0 2 0.4 2.6 1.1 0.6 0.7 0.8 1.8 0.6 2.9z" fill="#009CDE"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold">PayPal</h4>
                                        <p class="text-sm text-gray-500">Pay with your PayPal account</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Credit Card Form -->
                    <div id="credit-card-form" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                <input type="text" id="card_number" name="card_number" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="1234 5678 9012 3456">
                            </div>
                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="MM/YY">
                            </div>
                            <div>
                                <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="text" id="cvv" name="cvv" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="123">
                            </div>
                        </div>
                    </div>

                    <!-- PayPal Info -->
                    <div id="paypal-info" class="hidden bg-blue-50 p-4 rounded-lg mb-4">
                        <div class="flex items-center space-x-3">
                            <svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">
                                    You will be redirected to PayPal to complete your payment securely.
                                    After payment, you'll be returned to our site to view your tickets.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-semibold 
                                                   hover:bg-green-700 transition duration-150 ease-in-out">
                            Pay £{{ number_format($total, 2) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Payment method toggle
        const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
        const creditCardForm = document.getElementById('credit-card-form');
        const paypalInfo = document.getElementById('paypal-info');

        paymentMethodInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardForm.classList.remove('hidden');
                    paypalInfo.classList.add('hidden');
                } else {
                    creditCardForm.classList.add('hidden');
                    paypalInfo.classList.remove('hidden');
                }
            });
        });
    </script>
</x-app-layout>
