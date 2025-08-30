<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supports;
//use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Support\Facades\Auth;


class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Supports::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('customer.dashboard.support.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.dashboard.support.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'nullable|string|in:payment,booking,technical,other',
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:5120',
            
        ]);
    
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('support-attachments', 'public');
        }
    
        $data['user_id'] = auth()->id();
        $data['status'] = 'open';
    
        Supports::create($data);
        notifcate(
            Auth::id(),
            'تم فتح طلب دعم جديد',
            'تم فتح طلب دعم جديد من قبل العميل: ' . auth()->user()->name,
            [
                'type' => 'support',
            ],

        );
    
        return redirect()->route('customer.dashboard.support.index')->with('success', 'تم إرسال الطلب بنجاح ✅');
        
    }

    /**
     * Display the specified resource.
     */
public function show(string $id)
{
    $ticket = Supports::findOrFail($id);

    if ($ticket->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'لا يمكنك عرض هذا الطلب');
    }

    return view('customer.dashboard.support.chat', [
        'ticket' => $ticket,
        'support_id' => $ticket->id,
    ]);
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
        $ticket = Supports::findOrFail($id);
        if ($ticket->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك حذف هذا الطلب');
        }
        
        $ticket->delete();
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح ✅');
    }
}
