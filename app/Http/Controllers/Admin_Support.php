<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supports;

use function PHPUnit\Framework\isEmpty;

class Admin_Support extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Supports::orderBy('created_at', 'desc')->get();
            return view('admin.dashboard.support.index', compact('tickets'));   
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!adminPermission("tickets")) {
            return redirect()->route('dashboard.overview')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة ❌');
        }
        $ticket = Supports::findOrFail($id);
        return view('admin.dashboard.support.show', compact('ticket')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!adminPermission("tickets")) {
            return redirect()->route('dashboard.overview')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة ❌');
        }
        $ticket = Supports::findOrFail($id);
        if (isEmpty($ticket->staff_id)) {
            $ticket->staff_id = Auth::guard('admin')->user()->id;
            $ticket->status = 'pending';
            $ticket->save();

        }
        return view('admin.dashboard.support.chat', compact('ticket')); 

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
        if (!adminPermission("tickets")) {
            return redirect()->route('dashboard.overview')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة ❌');
        }
        $ticket = Supports::findOrFail($id);
        $ticket->status = 'closed';
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح');
    }
}
