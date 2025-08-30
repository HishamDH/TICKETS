<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class policies_settings extends Controller
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
        $finalID = can_enter($merchantid, "policies_view");
        
        $user = User::find($finalID);
        return view("merchant.dashboard.policies_settings",compact("user","merchantid", "finalID"));
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
    public function store(Request $request , $merchantid = null)
    {
        $finalID = can_enter($merchantid, "policies_edit");
        $request->validate([
            "policies" => "required|max:10000",
            'payments' => 'array',
            'payments.*' => 'in:visa-mastercard,mada,apple-pay,stc-pay',
            //'allow_refund' => 'nullable|boolean',
            'allow_refund' => 'nullable|boolean',

        ]);
        $data = [
            'policies' => $request->policies,
            'allow_refund' => $request->has('allow_refund'),
            'payments' => $request->input('payments', []),
        ];
        $user = User::find($finalID);
        //$user = auth()->user();
        $user->additional_data = array_merge($user->additional_data ?? [], $data);
        $user->save();
        //dd($user->additional_data);
        return redirect()->back()->with("success", "");
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
