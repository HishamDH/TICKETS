<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Bookings_restaurant extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::where('restaurant_id', Auth::id())->get();

        $bookings = Reservation::whereIn('branch_id', $branches->pluck('id'))
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        //dd($bookings);
        
        //dd($bookings);
        return view('seller.dashboard.sales', compact('bookings','branches'));

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
