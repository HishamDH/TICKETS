<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
class Tickets_sellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tickets = Ticket::all();

            $events = Auth::user()->events()->pluck('id');

            $tickets = Ticket::where('additional_data->event->vendor_id', (string)Auth::id())
            ->orWhereIn('event_id', $events)
            ->where('status', 'paid')
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'email'
                );
                }
            ])
              ->orderBy('created_at', 'desc')->paginate(10);



        //dd($tickets);


        return view('seller.dashboard.sales', compact('tickets', 'events'));

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
    public function show(string $id)
    {
        //
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
