@props(['match'])
@php
use Carbon\Carbon;
@endphp

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <!-- Stadium Image -->
    <div class="w-full h-48 overflow-hidden relative">
        @if($match->stadium_image)
            <img src="{{ url($match->stadium_image) }}"
                alt="{{ $match->stadium }}"
                class="w-full h-48 object-cover rounded-t-lg"
                onerror="this.onerror=null; this.src='{{ asset('images/default-stadium.jpg') }}';">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        
        <!-- Match Status Badge -->
        <div class="absolute top-4 right-4">
            <span class="px-3 py-1 text-sm font-semibold rounded-full
                @if($match->match_status === 'upcoming')
                    bg-green-100 text-green-800
                @elseif($match->match_status === 'completed')
                    bg-gray-100 text-gray-800
                @else
                    bg-yellow-100 text-yellow-800
                @endif">
                {{ ucfirst($match->match_status) }}
            </span>
        </div>
    </div>

    <!-- Match Details -->
    <div class="p-6">
        <!-- Teams -->
        <div class="flex justify-between items-center mb-4">
            <div class="text-xl font-bold text-gray-800">
                {{ $match->home_team }}
                <span class="text-gray-400 mx-2">vs</span>
                {{ $match->away_team }}
            </div>
        </div>

        <!-- Date, Time & Stadium -->
        <div class="space-y-2 mb-4">
            <div class="flex items-center text-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ Carbon::parse($match->match_date)->format('D, M d, Y') }}
            </div>
            
            <div class="flex items-center text-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ Carbon::parse($match->match_time)->format('h:i A') }}
            </div>

            <div class="flex items-center text-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                {{ $match->stadium }}
            </div>
        </div>

        <!-- Status and Price -->
        <div class="flex justify-between items-center mb-4">
            @php
                $totalAvailable = $match->ticketTypes->sum('available_tickets');
                $minPrice = $match->ticketTypes->min('price');
            @endphp
                
                <!-- Status Badge -->
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $totalAvailable > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $totalAvailable > 0 ? 'Available' : 'Sold Out' }}
                </span>

                <!-- Price -->
                <span class="text-green-600 font-semibold">
                    From £{{ number_format($minPrice, 2) }}
                </span>
            </div>

            <!-- Buy Button -->
            <div class="text-center">
                <a href="{{ route('tickets.create', ['match' => $match->id]) }}" 
                   class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-300 {{ $totalAvailable == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                   {{ $totalAvailable == 0 ? 'disabled' : '' }}>
                    Buy Tickets
                    <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
</div>
