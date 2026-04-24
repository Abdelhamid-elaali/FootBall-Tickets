<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket | {{ $ticket->match->home_team }} vs {{ $ticket->match->away_team }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .ticket-cut {
            background-image: radial-gradient(circle at center, transparent 6px, #f3f4f6 6px);
            background-size: 20px 20px;
            background-position: center;
        }
        .barcode-line {
            height: 40px;
            width: 2px;
            background: #000;
            display: inline-block;
            margin-right: 1px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-12 px-4">
    {{-- Navigation --}}
    <div class="max-w-md mx-auto mb-8">
        <button onclick="window.history.back()" class="group flex items-center px-4 py-2 text-sm font-bold text-gray-500 hover:text-green-600 transition-all">
            <div class="p-2 rounded-full bg-white shadow-sm border border-gray-100 mr-3 group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            Back to My Tickets
        </button>
    </div>

    <div class="max-w-md mx-auto relative group">
        {{-- Main Ticket --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-green-900/10 overflow-hidden border border-gray-100">
            
            {{-- Header --}}
            <div class="bg-gradient-to-br from-green-600 to-green-800 p-8 text-white text-center">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-xs font-black uppercase tracking-[0.3em] opacity-80 mb-1">Official E-Ticket</h1>
                <p class="text-2xl font-extrabold">{{ $ticket->match->home_team }} <span class="text-green-300">vs</span> {{ $ticket->match->away_team }}</p>
            </div>

            {{-- Match Info --}}
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Match Day</p>
                        <p class="text-sm font-black text-gray-900">{{ $ticket->match->match_date->format('l') }}</p>
                        <p class="text-xs font-bold text-gray-600">{{ $ticket->match->match_date->format('F j, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kick Off</p>
                        <p class="text-sm font-black text-gray-900">{{ $ticket->match->match_date->format('g:i A') }}</p>
                        <p class="text-xs font-bold text-green-600">Local Time</p>
                    </div>
                </div>

                <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Venue</p>
                    <div class="flex items-center">
                        <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-100 mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-black text-gray-900">{{ $ticket->match->stadium }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Seat Type</p>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-wider">
                            {{ $ticket->ticketType->type ?? 'Standard' }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Price Paid</p>
                        <p class="text-lg font-black text-gray-900">£{{ number_format($ticket->price, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Separator Line with Holes --}}
            <div class="relative h-px border-t-2 border-dashed border-gray-100 my-2">
                <div class="absolute -left-4 -top-3 w-6 h-6 bg-gray-100 rounded-full shadow-inner"></div>
                <div class="absolute -right-4 -top-3 w-6 h-6 bg-gray-100 rounded-full shadow-inner"></div>
            </div>

            {{-- Footer / Scanner --}}
            <div class="p-8 bg-gray-50/50 flex flex-col items-center text-center">
                <div class="mb-6 p-4 bg-white rounded-3xl shadow-xl border border-gray-100 group-hover:scale-105 transition-transform duration-500">
                    {{-- Placeholder for QR code --}}
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Scan at Entrance</p>
                    </div>
                </div>
                
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Ticket Number</p>
                <p class="text-sm font-mono font-black text-gray-800 tracking-widest mb-6 underline decoration-green-500 decoration-2 underline-offset-4">#{{ $ticket->ticket_number }}</p>

                <div class="space-y-4 w-full">
                    <p class="text-[9px] text-gray-400 leading-relaxed italic">
                        Please present this digital ticket at the gate. Entry is valid for one person only. 
                        Valid identification may be required upon request.
                    </p>
                    <div class="flex justify-center">
                        @for($i = 0; $i < 20; $i++)
                            <div class="barcode-line" style="width: {{ rand(1, 4) }}px; opacity: {{ rand(4, 10) / 10 }}"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Floating Action --}}
        <div class="mt-8 flex justify-center">
            <button onclick="window.print()" class="flex items-center px-6 py-3 bg-white text-gray-900 font-bold rounded-2xl shadow-lg border border-gray-100 hover:scale-105 active:scale-95 transition-all">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Ticket
            </button>
        </div>
    </div>
</body>
</html>
