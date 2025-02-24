<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FootballMatch;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MatchController extends Controller
{
    public function index()
    {
        $matches = FootballMatch::latest()->paginate(10);
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        return view('admin.matches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'home_team' => 'required|string|max:255',
            'away_team' => 'required|string|max:255',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'stadium' => 'required|string|max:255',
            'stadium_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ticket_types' => 'required|array',
            'ticket_types.*.price' => 'required|numeric|min:0',
            'ticket_types.*.available_tickets' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'match_status' => 'required|string|in:scheduled,live,completed,cancelled'
        ]);

        // Handle stadium image upload
        if ($request->hasFile('stadium_image')) {
            $image = $request->file('stadium_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/stadiums'), $imageName);
            $validated['stadium_image'] = '/images/stadiums/' . $imageName;
        }

        // Combine date and time
        $validated['match_date'] = date('Y-m-d H:i:s', strtotime($validated['match_date'] . ' ' . $validated['match_time']));
        unset($validated['match_time']);

        // Create the match
        $match = FootballMatch::create($validated);

        // Create ticket types
        foreach ($request->ticket_types as $type => $details) {
            TicketType::create([
                'match_id' => $match->id,
                'type' => $type,
                'price' => $details['price'],
                'available_tickets' => $details['available_tickets'],
            ]);
        }

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match created successfully with ticket types.');
    }

    public function show(FootballMatch $match)
    {
        // Get all ticket types for this match
        $ticketTypes = $match->ticketTypes()
            ->select('type', 'price')
            ->selectRaw('SUM(available_tickets) as available_tickets')
            ->groupBy('type', 'price')
            ->orderByRaw("FIELD(type, 'vip', 'premium', 'standard')")
            ->get();

        return view('admin.matches.show', compact('match', 'ticketTypes'));
    }

    public function edit(FootballMatch $match)
    {
        // Split the datetime for the form
        $match->match_time = date('H:i', strtotime($match->match_date));
        $match->match_date = date('Y-m-d', strtotime($match->match_date));
        
        return view('admin.matches.edit', compact('match'));
    }

    public function update(Request $request, FootballMatch $match)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'home_team' => 'required|string|max:255',
            'away_team' => 'required|string|max:255',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'stadium' => 'required|string|max:255',
            'stadium_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'match_status' => 'required|string|in:scheduled,live,completed,cancelled',
            'ticket_types' => 'required|array',
            'ticket_types.*.price' => 'required|numeric|min:0',
            'ticket_types.*.available_tickets' => 'required|integer|min:0'
        ]);

        // Handle stadium image upload
        if ($request->hasFile('stadium_image')) {
            // Delete old image
            if ($match->stadium_image) {
                Storage::disk('public')->delete($match->stadium_image);
            }
            
            // Store new image
            $image = $request->file('stadium_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/stadiums'), $imageName);
            $validated['stadium_image'] = '/images/stadiums/' . $imageName;
        }

        // Combine date and time
        $validated['match_date'] = date('Y-m-d H:i:s', strtotime($validated['match_date'] . ' ' . $validated['match_time']));
        unset($validated['match_time']);

        // Update match details
        $match->update($validated);

        // Update ticket types
        foreach ($request->ticket_types as $type => $details) {
            $match->ticketTypes()->updateOrCreate(
                ['type' => $type],
                [
                    'price' => $details['price'],
                    'available_tickets' => $details['available_tickets']
                ]
            );
        }

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match updated successfully.');
    }

    public function destroy(FootballMatch $match)
    {
        // Delete stadium image if exists
        if ($match->stadium_image) {
            Storage::disk('public')->delete($match->stadium_image);
        }

        $match->delete();

        return redirect()->route('admin.matches.index')
            ->with('success', 'Match deleted successfully.');
    }
}
