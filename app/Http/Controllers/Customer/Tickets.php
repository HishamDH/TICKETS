<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PaidReservation;
use App\Models\PaysHistory;
//use App\Models\Cart;

class Tickets extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Reservations = PaidReservation::where('user_id', Auth::id())->get();
        
        return view('customer.dashboard.tickets', compact('Reservations'));
    }

    public function tickets_print(){
        $Reservations = PaidReservation::where('user_id', Auth::id())->get();
        return view('customer.dashboard.tickets_print', compact('Reservations'));
    }

    public function tickets_cancel($id){
        $reservation = PaidReservation::findOrFail($id);
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        if (!can_cancel($reservation)){
            return redirect()->back()->with('error', 'Unauthorized action.');

        }

        /* هنا استرداد الفلوس لما يوفر لنا بوابة دفع */
        $oldData = json_decode($reservation->additional_data ?? '{}', true) ?? [];

        $newData = [
            'notes' => 'تم الاغاء بنجاح',
            'type' => 'refund',
            'withdrawal' => false, 
            'status' => 'pending',
        ];
        
        $merged = array_merge($oldData, $newData);
        $fee = ( (float) $reservation->price * (float) $reservation->offering->features["cancellation_fee"]) / 100;
        $amount = (float) $reservation->price  - $fee;
        logPayment([
            'user_id' => $reservation->user_id,
            'item_id' => $reservation->offering->id,
            'transaction_id' => uniqid('TXN_'),
            'payment_method' => 'paypal',
            'amount' => $amount,
            'additional_data' => $merged,
        ]);
        notifcate(
            Auth::id(),
            'تم استرداد المبلغ بنجاح',

            'تم الغاء الاشتراك في الخدمة ' . $reservation->offering->name . ' بنجاح',
            [
                'type' => 'refund',
                'offering_id' => $reservation->offering->id,
            ],

        );
        
        notifcate(
            $reservation->offering->user_id,
            Auth::user()->f_name . ' قام بالغاء الاشتراك في الخدمة بنجاح',

            'تم الغاء الاشتراك في الخدمة ' . $reservation->offering->name . ' بنجاح',
            [
                'type' => 'refund',
                'offering_id' => $reservation->offering->id,
            ],

        );
        $reservation->delete();
        return redirect()->back()->with('success', 'Ticket cancelled successfully.');
    }

    public function payHistory(){
        $user = Auth::guard('customer')->user();
        $paysHistory = PaysHistory::where('user_id', $user->id)->latest()->get();
        return view('customer.dashboard.pay_history', compact('paysHistory'));
    }
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
