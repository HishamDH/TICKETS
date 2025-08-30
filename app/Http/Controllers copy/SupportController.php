<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;
class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('visitor.dashboard.support.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('visitor.dashboard.support.help');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        SupportTicket::create([
            'title' => $validated['name'],
            'content' => $validated['message'],
            'user_id' => Auth::id(),
            'status' => 'pending',
            'code' => 'SUPPORT-' . strtoupper(uniqid()),
        ]);
        return redirect()->route('visitor.support.index')->with('success', 'Your support ticket has been created successfully.');
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
        $ticket = SupportTicket::findOrFail($id);
        return view('visitor.dashboard.support.edit',compact('ticket'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        if ($ticket->status !== 'pending') {
            return redirect()->route('visitor.support.index')->with('error', 'You can only update tickets that are pending.');
        }
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $ticket->update([
            'title' => $validated['name'],
            'content' => $validated['message'],
            'email' => $validated['email'],
            //'status' => 'pending',
        ]);

        return redirect()->route('visitor.support.index')->with('success', 'Your response has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('visitor.support.index')->with('success', 'Your support ticket has been deleted successfully.');
    }
}
