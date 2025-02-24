<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-16 p-4">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Buy Tickets</h2>
                    
                    <!-- Match Details -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Match Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">Match Name</p>
                                <p class="font-semibold">{{ $match->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Teams</p>
                                <p class="font-semibold">{{ $match->home_team }} vs {{ $match->away_team }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Stadium</p>
                                <p class="font-semibold">{{ $match->stadium }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Date & Time</p>
                                <p class="font-semibold">{{ $match->match_date->format('D, M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status</p>
                                <p class="font-semibold capitalize">{{ $match->match_status }}</p>
                            </div>
                        </div>

                        @if($match->stadium_image)
                            <div class="mt-4">
                                <img src="{{ url($match->stadium_image) }}" 
                                     alt="{{ $match->stadium }}" 
                                     class="w-full h-48 object-cover rounded-lg">
                            </div>
                        @endif

                        @if($match->description)
                            <div class="mt-4">
                                <p class="text-gray-600">Description</p>
                                <p class="mt-1">{{ $match->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Form -->
                    <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="match_id" value="{{ $match->id }}">

                        <!-- Ticket Type Selection -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Select Ticket Type</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($match->ticketTypes as $ticketType)
                                    <div class="relative">
                                        <input type="radio" 
                                               id="ticket_type_{{ $ticketType->type }}" 
                                               name="ticket_type" 
                                               value="{{ $ticketType->type }}"
                                               class="peer hidden" 
                                               {{ $loop->first ? 'checked' : '' }}
                                               onchange="updatePriceAndQuantity()">
                                        <label for="ticket_type_{{ $ticketType->type }}" 
                                               class="block p-6 bg-white border-2 rounded-lg cursor-pointer
                                                      peer-checked:border-green-500 peer-checked:bg-green-100
                                                      hover:bg-gray-50 transition-all duration-200">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="text-lg font-semibold capitalize text-gray-900">
                                                    {{ $ticketType->type }}
                                                </div>
                                                <div class="flex items-center justify-center w-6 h-6 border-2 rounded-full
                                                            peer-checked:border-green-500 peer-checked:bg-green-500">
                                                    <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M20 6L9 17l-5-5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="text-sm text-gray-600">
                                                    Price: <span class="font-medium text-gray-900">${{ number_format($ticketType->price, 2) }}</span>
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    Available: <span class="font-medium text-gray-900">{{ $ticketType->available_tickets }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('ticket_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity Selection -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Number of Tickets</h3>
                            <div class="relative">
                                <select id="quantity" 
                                        name="quantity" 
                                        class="block w-full pl-3 pr-10 py-3 text-base border-2 border-gray-300 
                                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 
                                               rounded-lg transition-all duration-200
                                               bg-white"
                                        onchange="updateTotal()">
                                </select>
                            </div>
                            @error('quantity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Amount -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-lg border-2 border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Total Amount</h3>
                                <p class="text-3xl font-bold text-green-600">$<span id="total-amount">0.00</span></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('home') }}" 
                               class="text-base font-medium text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 
                                           text-white text-base font-medium rounded-lg transition-colors duration-300">
                                Proceed to Payment
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store ticket types data
        const ticketTypes = @json($match->ticketTypes);
        
        // Function to update quantity options based on selected ticket type
        function updatePriceAndQuantity() {
            const selectedType = document.querySelector('input[name="ticket_type"]:checked').value;
            const ticketType = ticketTypes.find(t => t.type === selectedType);
            const quantitySelect = document.getElementById('quantity');
            
            // Clear existing options
            quantitySelect.innerHTML = '';
            
            // Add new options based on available tickets (max 10)
            const maxTickets = Math.min(10, ticketType.available_tickets);
            for (let i = 1; i <= maxTickets; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `${i} ${i === 1 ? 'ticket' : 'tickets'}`;
                quantitySelect.appendChild(option);
            }
            
            // Update total
            updateTotal();
        }
        
        // Function to update total amount
        function updateTotal() {
            const selectedType = document.querySelector('input[name="ticket_type"]:checked').value;
            const ticketType = ticketTypes.find(t => t.type === selectedType);
            const quantity = parseInt(document.getElementById('quantity').value);
            const total = (quantity * ticketType.price).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            document.getElementById('total-amount').textContent = total;
        }
        
        // Initialize the form
        updatePriceAndQuantity();
    </script>
</x-app-layout>
