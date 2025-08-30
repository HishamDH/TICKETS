<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Reservation;
use Carbon\Carbon;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $restaurant, $branch)
    {
        $branch = Branch::findOrFail($branch);

        $user = $restaurant;
        // dd($branch);
        if ($branch->restaurant_id != $user->id) {
            return redirect()->route('visitor.bran.show', ['restaurant' => $restaurant->id])->with('error', 'You are not authorized to view this branch.');
        }
        return view('visitor.dashboard.restaurent.table_details', compact('branch', 'user'));
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(User $restaurant)
    {

        $branches = Branch::where('restaurant_id', $restaurant->id)->get();

        //dd($branches);
        $categories = Category::active()->where('type', 'events')->get();


        return view('visitor.dashboard.restaurent.branch_preview', compact('branches', 'categories', 'restaurant'));
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
    public function getSchedule(Request $request)
    {
        $branchId = $request->branch_id;
        $date = $request->date;

        $branch = Branch::findOrFail($branchId);
        $tablesCount = $branch->tables;

        $reservations = Reservation::where('branch_id', $branchId)
            ->whereDate('reservation_date', $date)
            ->get(['start_time', 'end_time']);

        return response()->json([
            'tables' => $tablesCount,
            'reservations' => $reservations
        ], 200);
    }
}
