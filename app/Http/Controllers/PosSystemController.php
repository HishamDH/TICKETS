<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaidReservation;
class PosSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($merchantid = null)
    {
        if(is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending' && !isset($merchantid)){
            //session()->regenerate();
            return redirect()->route("merchant.dashboard.work_center.index");
            
        }
        //dd(can_enter($merchantid, "pos_page"));
        $finalID = can_enter($merchantid, "pos_page");
        $reservations = PaidReservation::where('user_id', $finalID)
        ->where('additional_data->selling_type', 'pos')
        ->orderBy('created_at', 'desc')
        ->get();
    
            return view('merchant.dashboard.pos.pos', compact('reservations',"merchantid"));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($merchantid = null)
    {
        $finalID = can_enter($merchantid, "pos_create");

        return view('merchant.dashboard.pos.create',compact('merchantid'));
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
    public function show($merchantid = null, $id= null)
    {
        //dd($merchantid, $id);
        if ($id === null) {
            $id = $merchantid;
            $merchantid = null;
        }
        $finalID = can_enter($merchantid, "pos_view");

        $reservation = PaidReservation::findOrFail($id);
        //dd($reservation);
  
        
        return view('merchant.dashboard.pos.preview', compact('reservation',"merchantid"));
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
    public function destroy($merchantid = null,string $id)
    {
        if ($id === null) {
            $id = $merchantid;
            $merchantid = null;
        }
        $finalID = can_enter($merchantid, "pos_delete");

        $reservation = PaidReservation::findOrFail($id);
        ///dd($finalID,$reservation->user_id);
        if ((string ) $reservation->user_id !== $finalID) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        $reservation->delete();
        
        return redirect()->back()->with('success', 'Reservation deleted successfully.');
    }
}
