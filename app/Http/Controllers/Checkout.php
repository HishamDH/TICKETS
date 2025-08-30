<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaidReservation;
use App\Models\Cart;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
class Checkout extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function paid($id){
        $user = Auth::guard('customer')->user()->id;

        $cart = Cart::where('user_id', $user)->get();

        foreach ($cart as $item) {
            PaidReservation::create([
                'item_id' => $item->item_id,
                'item_type' => $item->item_type,
                'user_id' => $user,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                //'final_price' => $item->price - $item->discount,
                'code' => uniqid('code_'),
                'additional_data' => $item->additional_data,
            ]);
            //dd($item->offering->id);
            $oldData = json_decode($item->additional_data ?? '{}', true) ?? [];
            $newData = [
                'recipient_id' => $item->user_id,
                'notes' => 'تم الدفع بنجاح',
                'type' => 'pay',
                'withdrawal' => false, 
                'status' => 'pending',
            ];
            
            $merged = array_merge($oldData, $newData);
            
            logPayment([
                'user_id' => $user,
                'item_id' => $item->offering->id,
                'transaction_id' => uniqid('TXN_'),
                'payment_method' => 'paypal',
                'amount' => $item->price,
                'additional_data' => $merged,
            ]);
            notifcate(
                $item->offering->user_id,
                Auth::user()->f_name . ' قام بالدفع بنجاح',
                'تم الدفع بنجاح للعرض: ' . $item->offering->name,
                [
                    'type' => 'payment',
                    'offering_id' => $item->offering->id,
                    
                ],
            );
            
            notifcate(
                Auth::id(),
                'تم الدفع بنجاح',
                'تم الدفع بنجاح للعرض: ' . $item->offering->name,
                [
                    'type' => 'payment',
                    'offering_id' => $item->offering->id,
                    
                ],
            );

            $item->delete(); // Remove the item from the cart after creating the reservation

        }
        return redirect()->route('template1.checkout.success',['id'=>$id])->with('success', 'Reservations created successfully');
        // return response()->json(['message' => 'Reservations created successfully'], 201);
    }
    public function success($id){
        $merchant = User::findOrFail($id);
        $user = Auth::guard('customer')->user();
        $reservations = PaidReservation::where('user_id', $user->id)->get();
        return view('templates.tmplate1.success', compact('user','id', 'reservations','merchant'));
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
