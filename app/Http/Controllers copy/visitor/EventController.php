<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'category' => 'nullable|exists:categories,id',
            'minPrice' => 'nullable|numeric|max:99999|min:0',
            'maxPrice' => 'nullable|numeric|max:10000|min:1',
        ]);
        $events = Event::where('status', 'active');
        if (isset($validated['search']) && $validated['search'] != '') {
            $events = $events->where('name', 'like', '%' . $validated['search'] . '%')->orWhere('description', 'like', '%' . $validated['search'] . '%')->orwhere('location', 'like', '%' . $validated['search'] . '%');
        }
        if (isset($validated['date']) && $validated['date'] != '') {
            $events = $events->whereDate('date', $validated['date']);
        } else {
            $events = $events->where('date', '>', now());
        }
        if (isset($validated['category']) && $validated['category'] != '') {
            $events = $events->where('category_id', $validated['category']);
        }
        if (isset($validated['minPrice']) && $validated['minPrice'] != '') {
            $events = $events->where('ticket_price', '>=', $validated['minPrice']);
        }
        if (isset($validated['maxPrice']) && $validated['maxPrice'] != '') {
            $events = $events->where('ticket_price', '<=', $validated['maxPrice']);
        }
        $events = $events->orderBy('date', 'asc')->paginate(12);
        // ->paginate(12);
        // where('date','>',now())->
        $categories = Category::where('type', 'events')->where('status', 'active')->get();

        return view('visitor.dashboard.explore_events', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $user = $event->user;

        return view('visitor.dashboard.details.details', compact('event', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
