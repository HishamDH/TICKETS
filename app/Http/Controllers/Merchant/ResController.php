<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaidReservation;
use App\Models\PaysHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResController extends Controller
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
        $finalID = can_enter($merchantid,"reservations_view");


        $bundling = collect();
        $finished = collect();
        $NotPresent = collect();
        
        $reservations = PaidReservation::whereHas('offering', function($query) use ($finalID) {
            $query->where('user_id', $finalID);
        })->get();
        
        $now = Carbon::now();
        
        foreach ($reservations as $res) {
            $data = json_decode($res->additional_data, true);
            $selectedDate = isset($data['selected_date']) ? Carbon::parse($data['selected_date']) : null;
            $selectedTime = isset($data['selected_time']) ? $data['selected_time'] : '00:00';
            
            $reservationDateTime = $selectedDate ? $selectedDate->setTimeFromTimeString($selectedTime) : null;
        
            if ($res->quantity > 0 && $reservationDateTime && $reservationDateTime->gte($now)) {
                $bundling->push($res);
            } elseif ($res->quantity > 0 && $reservationDateTime && $reservationDateTime->lt($now)) {
                $NotPresent->push($res);
            }else{
                $finished->push($res);
            }
        }
        
        //dd($bundling, $finished);
        return view('merchant.dashboard.reservations.reservations', compact('bundling',"NotPresent","finished",'merchantid'));
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
    public function show($merchantid = null,string $id = null)
    {
        //dd($merchantid, Auth::id());
        //dd(fetch_Permetions(Auth::id(), $merchantid));
        //dd(has_Permetion(Auth::id(),"reservation_detail", $merchantid));

        if ($id === null) {
            $id = $merchantid;
            $merchantid = null;
        }
        //dd(1);

        $finalID = can_enter($merchantid,"reservation_detail");

        $reservation = PaidReservation::findOrFail($id);
        $offering = $reservation->item;
        $user = $reservation->user;
        $reservation->load('offering', 'user');
        return view('merchant.dashboard.reservations.info', compact('reservation', 'offering', 'user','merchantid'));
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
    public function update(Request $request, string $id, $merchantid = null)
    {
        //dd($merchantid, $id);
        if ($id === null) {
            $id = $merchantid;
            $merchantid = null;
        }
        $finalID = can_enter($merchantid,"reservations_edit");

        $reservation = PaidReservation::findOrFail($id);

        
        $oldData = json_decode($reservation->additional_data ?? '{}', true) ?? [];

        $selectedDate = isset($oldData['selected_date']) ? Carbon::parse($oldData['selected_date']) : null;
        $selectedTime = isset($oldData['selected_time']) ? $oldData['selected_time'] : '00:00';
        $now = Carbon::now();
        $reservationDateTime = $selectedDate ? $selectedDate->setTimeFromTimeString($selectedTime) : null;
    
        if (!($reservation->quantity > 0 && $reservationDateTime && $reservationDateTime->gte($now))) {
            abort(403);
        }
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'selectedTime' => 'required|string',
            'selectedDate' => 'required|string',

        ]);
        $reservation->quantity = $request->quantity;
        $oldData["selectedTime"] = $request->selectedTime;
        $oldData["selectedDate"] = $request->selectedDate;
        $reservation->additional_data = $oldData;
        $reservation->save();
        
        return redirect()->back()->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $merchantid = null,string $id = null)
    {
        //dd($merchantid, $id);
        if ($id === null) {
            $id = $merchantid;
            $merchantid = null;
        }
        $finalID = can_enter($merchantid,"reservations_delete");

        $reservation = PaidReservation::findOrFail($id);


        $oldData = json_decode($reservation->additional_data ?? '{}', true) ?? [];

        $selectedDate = isset($oldData['selected_date']) ? Carbon::parse($oldData['selected_date']) : null;
        $selectedTime = isset($oldData['selected_time']) ? $oldData['selected_time'] : '00:00';
        $now = Carbon::now();
        $reservationDateTime = $selectedDate ? $selectedDate->setTimeFromTimeString($selectedTime) : null;
    
        if (!($reservation->quantity > 0 && $reservationDateTime && $reservationDateTime->gte($now))) {
            abort(403);
        }

        $newData = [
            'notes' => 'تم الاغاء بنجاح',
            'type' => 'refund',
            'withdrawal' => false, 
            'status' => 'pending',
        ];
        
        $merged = array_merge($oldData, $newData);
        //$fee = ( (float) $reservation->price * (float) $reservation->offering->features["cancellation_fee"]) / 100;
        $amount = (float) $reservation->price ;
        logPayment([
            'user_id' => $reservation->user_id,
            'item_id' => $reservation->offering->id,
            'transaction_id' => uniqid('TXN_'),
            'payment_method' => 'paypal',
            'amount' => $amount,
            'additional_data' => $merged,
        ]);
        notifcate(
            $reservation->user_id,
            'تم استرداد المبلغ بنجاح',

            'تم الغاء الاشتراك في الخدمة ' . $reservation->offering->name . ' بنجاح',
            [
                'type' => 'refund',
                'offering_id' => $reservation->offering->id,
            ],

        );
        
        notifcate(
            $reservation->offering->user_id,
            ' قام بالغاء الاشتراك في الخدمة بنجاح',
            'تم الغاء الاشتراك في الخدمة ' . $reservation->offering->name . ' بنجاح',
            [
                'type' => 'refund',
                'offering_id' => $reservation->offering->id,
            ],

        );
        $reservation->delete();
        return redirect()->back()->with('success', 'Ticket cancelled successfully.');
    }
}
