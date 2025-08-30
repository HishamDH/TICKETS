<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RestaurentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = User::where('role', 'restaurant')->get();

        
        //$branchs = Branch::all();
        $categories = Category::where('type', 'restaurants')->where('status', 'active')->get();
        return view('visitor.dashboard.restaurent.explore_restaurents',compact('restaurants','categories'));
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
        $restaurant = Branch::findOrFail($id);
        $user = User::findOrFail($restaurant->restaurent_id);

        

        return view('visitor.dashboard.restaurent.table_details',compact('restaurant','user'));
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
