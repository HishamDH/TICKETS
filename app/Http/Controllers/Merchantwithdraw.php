<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Http\Controllers\Controller;
use App\Models\MerchantWallet;
use App\Models\withdraws_log;
use App\Models\User;
class Merchantwithdraw extends Controller
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
        $finalID = can_enter($merchantid,"wallet_view");

        $wallet = MerchantWallet::where('merchant_id', $finalID)->first();
        $withdraws = withdraws_log::where('user_id', $finalID)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('merchant.dashboard.wallet_withdrawal', compact('wallet','withdraws','merchantid'));
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
    public function store(Request $request,$merchantid = null)
    {
        $finalID = can_enter($merchantid,"wallet_withdraw");

        //dd($finalID, $merchantid,$request->all());
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'account_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s\.\-\'،]+$/u',
                ],
            'bank_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s\.\-\'،]+$/u',
                ],
            'iban' => [
                    'required',
                    'string',
                    'max:34',
                    'regex:/^[A-Z0-9]+$/',
                ],
            'swift' => [
                    'nullable',
                    'string',
                    'max:11',
                    'regex:/^[A-Z0-9]{8,11}$/',
                ],
            
        ]);
        $wallet = MerchantWallet::where('merchant_id', $finalID)->first();

        if ((float)$validated['amount'] > $wallet->balance){
            return redirect()->back()->with("fail","لاتحتوي على هذا الرقم في محفضتك");
        }
        //dd($validated);

        $newBalance = (float)$wallet->balance - (float)$validated['amount'];
        //dd($newBalance);
        $wallet->balance = $newBalance;
        $wallet->save();
        
        $withdraw = withdraws_log::create([
            'user_id' => $finalID,
            'withdraw_id' => uniqid('withdraw_'),
            'amount' => $validated['amount'],
            'status' => 'pending',
            'additional_data' => [
                'account_name' => $validated['account_name'],
                'bank_name'    => $validated['bank_name'],
                'iban'         => $validated['iban'],
                'swift'        => $validated['swift'],
            ],
        ]);

        notifcate(
            $finalID,
            'تم طلب السحب بنجاح' . $validated['amount'],
            'تستغرق العملية حوالي 24 ساعة او اكثر',
            [
                'type' => 'payment',
                'withdrawal' => true,
                'status' => 'pending',
                'recipient_id' => $finalID,
                'transaction_id' => $withdraw->withdraw_id,
                'amount' => $withdraw->amount,

            ],
        );
        
        //dd($withdraw);
        if (!$merchantid){
            return redirect()->route('merchant.dashboard.withdraws.index')->with('success', 'تم إرسال طلب السحب بنجاح ✅');

        }else{
            return redirect()->route('merchant.dashboard.m.withdraws.index',$merchantid)->with('success', 'تم إرسال طلب السحب بنجاح ✅');

        }

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
