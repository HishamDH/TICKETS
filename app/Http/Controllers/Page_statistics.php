<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\page_views;
use App\Models\PaysHistory;
use App\Models\PaidReservation;
use App\Models\withdraws_log;
use Illuminate\Support\Facades\Auth;
use App\Models\MerchantWallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Page_statistics extends Controller
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
        $finalID = can_enter($merchantid,"reports_view");

        $statistics = get_statistics($finalID); //Global function to get statistics
        $txns = $statistics['txns'];
        $wallet = $statistics['wallet'];
        $offers = $statistics['offers'];
        $offersPercent = $statistics['offersPercent'];
        $all_selles = $txns->count();
        $all_refunds = $statistics['refunds']->count();
        $all_payments = $statistics['payments']->count();

        $amount = $txns->sum('amount');
        $amount_refunds = $statistics['refunds']->sum('amount');
        $amount_payments = $statistics['payments']->sum('amount');

        $refundPercent = $all_refunds > 0 ? round(($all_refunds / $all_selles) * 100, 2) : 0;
        $PayPercent = $all_payments > 0 ? round(($all_payments / $all_selles) * 100, 2) : 0;
        $views = page_views::where('merchant_id', $finalID)->count();
        $couponLoss = 0;
        unset($statistics);
        $Peak_Time = Peak_Time($finalID);
        $dailyPeaks = [];
        //dd($Peak_Time);
        foreach ($Peak_Time as $day => $hoursArray) {
            $maxHour = array_keys($hoursArray, max($hoursArray))[0];
            $dailyPeaks[$day] = $maxHour;
        }
        $maxDay = null;
        $maxHour = null;
        $maxValue = 0;

        foreach ($Peak_Time as $day => $hoursArray) {
            foreach ($hoursArray as $hour => $count) {
                if ($count > $maxValue) {
                    $maxValue = $count;
                    $maxDay = $day;
                    $maxHour = $hour;
                }
            }
        }
        $sells_day = [];
        foreach ($Peak_Time as $day => $hoursArray) {
            $sell = 0;
            foreach ($hoursArray as $hour){
                $sell+=$hour;
            }
            $sells_day[$day] = $sell;
        }
        //dd($sells_day);
        //dd($Peak_Time);
        //dd($PayPercent,$refundPercent);
        return view('merchant.dashboard.reports_analysis', compact('txns', 'wallet', 'offers', 'offersPercent',
            'all_selles', 'all_refunds', 'all_payments','PayPercent', 'refundPercent', 'views', 'couponLoss','Peak_Time', 'dailyPeaks', 'maxHour', 'maxDay', 'maxValue','sells_day','merchantid'));
        
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
