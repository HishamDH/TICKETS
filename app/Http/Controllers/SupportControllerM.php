<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supports;
//use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Support\Facades\Auth;


class SupportControllerM extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($merchantid = null)
    {
        $finalID = can_enter($merchantid, "support_view");
        if(is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending' && !isset($merchantid)){
            //session()->regenerate();
            return redirect()->route("merchant.dashboard.work_center.index");
            
        }
        $tickets = Supports::where('user_id', $finalID)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('merchant.dashboard.support.index',compact('tickets',"merchantid", 'finalID'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($merchantid = null)
    {
        $finalID = can_enter($merchantid, "support_open");
        return view('merchant.dashboard.support.create',compact("merchantid","finalID"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$merchantid = null)
    {
        $finalID = can_enter($merchantid, "support_open");
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'nullable|string|in:payment,booking,technical,other',
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:5120',
            
        ]);
    
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('support-attachments', 'public');
        }
    
        $data['user_id'] = $finalID;
        $data['status'] = 'open';
    
        Supports::create($data);
        notifcate(
            $finalID,
            'تم فتح طلب دعم جديد',
            'تم فتح طلب دعم جديد من قبل العميل: ' . auth()->user()->name,
            [
                'type' => 'support',
            ],

        );
        if ($merchantid) {
            return redirect()->route('merchant.dashboard.m.support.index', ['merchant' => $merchantid])->with('success', 'تم إرسال الطلب بنجاح ✅');
        }
        return redirect()->route('merchant.dashboard.support.index')->with('success', 'تم إرسال الطلب بنجاح ✅');
        
    }

    /**
     * Display the specified resource.
     */
public function show(string $id, $merchantid = null)
{
    if ($merchantid != null) {
        $tmp = $merchantid;
        $merchantid = $id;
        $id = $tmp;
    }
    $finalID = can_enter($merchantid, "support_view");
    $ticket = Supports::findOrFail($id);

    if ($ticket->user_id != $finalID) {
        return redirect()->back()->with('error', 'لا يمكنك عرض هذا الطلب');
    }

    return view('merchant.dashboard.support.chat', [
        'ticket' => $ticket,
        'support_id' => $ticket->id,
        'merchantid' => $merchantid,
        'finalID' => $finalID,

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
    public function destroy(string $id,$merchantid = null)
    {
        if ($merchantid != null) {
            $tmp = $merchantid;
            $merchantid = $id;
            $id = $tmp;
        }
        $finalID = can_enter($merchantid, "support_delete");

        $ticket = Supports::findOrFail($id);
        if ($ticket->user_id != $finalID) {
            return redirect()->back()->with('error', 'لا يمكنك حذف هذا الطلب');
        }
        
        $ticket->delete();
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح ✅');
    }
}
