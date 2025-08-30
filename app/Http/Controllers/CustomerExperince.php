<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CustomerExperince extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        
        //dd($offerings, $finished, $ratings);

        return view("customer.dashboard.expirence");
    }
    //{"selected_date":"2025-07-3","selected_time":"04:53","coupon_code":"","branch":"1","Qa":[]}
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
