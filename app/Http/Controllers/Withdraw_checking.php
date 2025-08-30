<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaysHistory;
use App\Http\Controllers\Controller;
use App\Models\withdraws_log;
use Illuminate\Support\Facades\DB;

class Withdraw_checking extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!adminPermission("withdraw_check")) {
            return redirect()->route('dashboard.overview')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة ❌');
        }
        $logs = withdraws_log::where('status', 'pending')
            ->get();
        return view('admin.dashboard.withdraws.withdraws_check', compact('logs'));
    }

    public function index2()
    {
        //dd(1);
        $logs = withdraws_log::where('status', 'completed')->orWhere('status', 'cancelled')
            ->paginate(10);
        return view('admin.dashboard.withdraws.withdrawsCheked', compact('logs'));
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
    public function show(string $id)
    {
        
        $log = withdraws_log::findOrFail($id);
        $log->load('user');
        ///dd($log);
        $decoded_transactions = $log->additional_data;
        //dd($decoded_transactions);
        //$transaction_id =  collect($decoded_transactions)->pluck('transaction_id')->all();
        $transactions = PaysHistory::whereIn('transaction_id', $decoded_transactions)->get();
        //dd($transactions, $log, $decoded_transactions);



        return view('admin.dashboard.withdraws.withdraw_see', compact('log','transactions'));
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
        if (!adminPermission("withdraw_check")) {
            return redirect()->route('dashboard.overview')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة ❌');
        }
        $log = withdraws_log::findOrFail($id);


         $wallet = $log->user->wallet;
        // $wallet->balance -= $log->amount;
        // $wallet->withdrawn_total += $log->amount;
        // $wallet->save();
        DB::transaction(function () use ($wallet, $log) {

            // if ($wallet->balance < $log->amount) {
            //     throw new \Exception("الرصيد غير كافي");
            // }
    
            //$wallet->balance -= $log->amount;
            $wallet->withdrawn_total += $log->amount;
            $wallet->save();
    
            $log->status = 'completed';
            //$log->save();
            $log->save();
        });
        // $decoded_transactions = json_decode($log->additional_data, true);
        // $transactions = PaysHistory::whereIn('transaction_id', $decoded_transactions)->get();
        
        // foreach ($transactions as $transaction) {
        //     $data = $transaction->additional_data ?? [];
        //     if (!is_array($data)) {
        //         $data = json_decode($data, true) ?? [];
        //     }
        //     $data['status'] = 'paid';  
        //     $transaction->additional_data = json_encode($data);
        //     $transaction->save();
        // }
        notifcate(
            $log->user_id,
            'تم  السحب',
            'تم قبول السحب' ,
            [
                'type' => 'withdraw',
                'withdrawal' => true,
                $log->withdraw_id => $log->withdraw_id,
                'status' => 'completed',
                'recipient_id' => $log->user_id,
                                
            ],
        );

        return redirect()->route('admin.dashboard.withdraws.index')->with('success', 'Withdraw log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $log = withdraws_log::findOrFail($id);
        // $log->status = 'cancelled';
        //$log->save();
        $wallet = $log->user->wallet;
        DB::transaction(function () use ($wallet, $log) {


    
            //$wallet->balance -= $log->amount;
            $wallet->locked_balance += $log->amount;
            $wallet->save();
    
            $log->status = 'cancelled';
            //$log->save();
            $log->save();
        });
        // $decoded_transactions = json_decode($log->additional_data, true);
        // $transactions = PaysHistory::whereIn('transaction_id', $decoded_transactions)->get();
        
        // foreach ($transactions as $transaction) {
        //     $data = $transaction->additional_data ?? [];
        //     if (!is_array($data)) {
        //         $data = json_decode($data, true) ?? [];
        //     }
        //     $data['status'] = 'cancelled';  
        //     $transaction->additional_data = json_encode($data);
        //     $transaction->save();
        // }

        return redirect()->route('admin.dashboard.withdraws.index')->with('success', 'Withdraw log deleted successfully.');
    }
}
