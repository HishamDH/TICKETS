<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class WorkCenter extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending' && !isset($merchantid)){
        //     //session()->regenerate();
        //     return redirect()->route("merchant.dashboard.work_center.index");
            
        // }
        $workPLaces = GetWorkPlace(Auth::id());
        $workPLace = User::find($workPLaces);
        if (!$workPLace) {
            return redirect()->route('dashboard.overview')->with('error', 'لا يوجد مكان عمل مرتبط بهذا المستخدم.');
        }
        //dd($workPLace);
        return view('merchant.dashboard.work_center', [
            'workPLace' => $workPLace,
            'workPLaces' => $workPLaces,
        ]);
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
