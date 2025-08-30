<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
        ->whereHas('event')
        ->with(['event' => function ($query) {
            $query->select('id', 'image', 'name', 'date', 'location');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('visitor.dashboard.tickets', compact('tickets'));
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
    public function store(Event $event, Request $request)
    {
        $event->tickets()->create([
            'user_id' => Auth::id(),
            'price' => $event->ticket_price,
            'status' => 'pending',
            'code' => 'TICKET-' . strtoupper(uniqid()),
            'additional_data' => [
                'event'=>[
                    'id' => $event->id,
                    'name' => $event->name,
                    'vendor_id' => $event->user_id,
                    'vendor_name' => $event->user->name,
                    'date' => $event->date,
                    'image' => $event->image,
                ]
            ],
        ]);
        return redirect()->back()->with('success', 'Ticket booked successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        if($ticket->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to update this ticket.');
        }
        if($ticket->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending tickets can be updated.');
        }

        if ($ticket->status !== 'paid') {
            $ticket->status = 'paid';
            $ticket->save();
        }

        return redirect()->route('visitor.tickets.index')->with('success', 'Ticket updated ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        if($ticket->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this ticket.');
        }
        if($ticket->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending tickets can be deleted.');
        }
        $ticket->delete();
        return redirect()->route('visitor.tickets.index')->with('success', 'Ticket deleted successfully!');
    }
}
