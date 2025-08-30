<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function store(Request $request,string $id)
    {
        $chat = SupportTicket::findOrFail($id);
        //dd($chat);

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message=  message::create([

            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'ticket_id' => $chat->id,

        ]);
        //$message->save();
        return redirect()->route('visitor.support_chat.show',$chat->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chat = SupportTicket::findOrFail($id);

        //$messages = message::where('ticket_id',$id)->get();

        $messages = Message::with(['user', 'staff']) 
            ->where('ticket_id', $id)
            ->get();


        return view('visitor.dashboard.support_chat.chat',compact('messages','chat'));
    }

    public function ajaxMessages($id)
    {
        $messages = Message::where('ticket_id', $id)
            ->with(['user', 'staff'])
            ->orderBy('created_at', 'asc')
            ->get();

        $data = $messages->map(function ($msg) {
            $sender = $msg->user_id ? $msg->user : $msg->staff;

            return [
                'message' => $msg->message,
                'user_id' => $msg->user_id,
                'staff_id' => $msg->staff_id,
                'sender_name' => $sender->name ?? 'غير معروف',
                'sender_image' => $sender->additional_data['image'] ?? null,
            ];
        });

        return response()->json($data);
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