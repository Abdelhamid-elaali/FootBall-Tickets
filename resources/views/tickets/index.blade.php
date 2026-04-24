<x-app-layout>
    <div class="py-12 mt-16 p-4 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight italic">My <span class="text-green-600">Tickets</span></h2>
                    <p class="text-gray-500 mt-2 font-medium">Manage and download your upcoming match tickets</p>
                </div>
                <div class="flex items-center space-x-2 bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100">
                    <span class="px-4 py-2 text-sm font-bold text-green-700 bg-green-50 rounded-xl">Total: {{ $tickets->count() }}</span>
                </div>
            </div>

            @if($tickets->isEmpty())
                <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No tickets found</h3>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">You haven't purchased any tickets yet. Ready for the next big match?</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-bold rounded-2xl hover:bg-green-700 transition-all shadow-lg shadow-green-600/20 active:scale-95">
                        Browse Matches
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tickets as $ticket)
                        <div class="group relative bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-gray-200/50 border border-gray-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            {{-- Header Gradient --}}
                            <div class="h-36 bg-gradient-to-br from-green-600 to-green-800 p-8 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <span class="px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-[0.2em] border border-white/20">
                                        {{ $ticket->ticketType->type ?? 'Standard' }}
                                    </span>
                                    <div class="flex items-center space-x-1.5 bg-black/20 backdrop-blur-sm px-2.5 py-1 rounded-full border border-white/10">
                                        <div class="w-2 h-2 rounded-full {{ $ticket->status === 'paid' ? 'bg-green-400 animate-pulse' : 'bg-yellow-400' }}"></div>
                                        <span class="text-[10px] font-bold text-white uppercase tracking-tighter">{{ $ticket->status }}</span>
                                    </div>
                                </div>
                                <h3 class="text-2xl font-black text-white leading-tight truncate drop-shadow-sm">
                                    {{ $ticket->match->home_team }} <span class="text-green-300">vs</span> {{ $ticket->match->away_team }}
                                </h3>
                            </div>

                            <div class="p-8">
                                <div class="grid grid-cols-2 gap-6 mb-8">
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Date</p>
                                        <p class="text-sm font-bold text-gray-900">{{ $ticket->match->match_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500 font-semibold">{{ $ticket->match->match_date->format('g:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Stadium</p>
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $ticket->match->stadium }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-5 bg-gray-50 rounded-2xl border border-gray-100 mb-8">
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Ticket Number</p>
                                        <p class="text-sm font-mono font-black text-gray-800 tracking-wider">#{{ $ticket->ticket_number }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex flex-col space-y-3">
                                    <a href="{{ route('tickets.download', $ticket) }}" 
                                       class="flex items-center justify-center w-full px-6 py-4 bg-black text-white font-bold rounded-2xl hover:bg-gray-800 transition-all shadow-xl shadow-gray-900/10 active:scale-[0.98]">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View E-Ticket
                                    </a>
                                    <a href="{{ route('tickets.download-pdf', $ticket) }}" 
                                       class="flex items-center justify-center w-full px-6 py-4 bg-white text-gray-900 font-bold rounded-2xl border-2 border-gray-100 hover:border-red-500 hover:text-red-600 transition-all active:scale-[0.98]">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
