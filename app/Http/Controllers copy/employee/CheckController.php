<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;

class CheckController extends Controller
{

    public function index()
    {
        $sellers = User::where('role', 'seller')->get()
        ->filter(function ($sellers) {
            $data = json_decode($sellers->additional_data);
            return isset($data->accepted) && $data->accepted == 'yes';
        })->pluck('id')->toArray();
        $events = Event::whereIn('user_id', $sellers)
        ->with('user')
        ->get();
        
        $events = $events->filter(function ($event) {
            $data = json_decode($event->additional_data);
            return isset($data->accepted) && $data->accepted === 'no';
        });

        //dd($events);
        
        return view('employee.dashboard.acceptes', compact('events', 'sellers'));
    }


    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        $user = $event->user;
        
        //dd($event);
        return view('employee.dashboard.details', compact('event', 'user'));
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
        $event = Event::findOrFail($id);
        $data = json_decode($event->additional_data, true) ?? [];

        $data['accepted'] = 'yes';
        $data['accepted_at'] = now();
        $data['accepted_by'] = Auth::user()->id; 
        
        $event->additional_data = json_encode($data);
        
        $event->save();
        return redirect()->route('employee.check.index')->with('success', 'Seller accepted successfully.');

            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('employee.check.index')->with('success', 'Event deleted successfully.');
    }
}
