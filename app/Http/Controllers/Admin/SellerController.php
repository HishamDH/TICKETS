<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->orwhere('role','restaurant')
            ->whereNotNull('additional_data')
            //->where('additional_data->accepted', json_encode('no'))
            ->orderBy('created_at', 'desc')
            ->paginate(100)
            ->filter(function ($user) {
                $data = json_decode($user->additional_data);
                return isset($data->phone, $data->location,$data->accepted) && !empty($data->phone) && !empty($data->location) && $data->accepted == 'no';
            });


        //dd($sellers);
        
        return view('admin.dashboard.sellers',compact('sellers'));
    }

    public function create()
    {
        
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
        $seller = User::findOrFail($id);
        $data = json_decode($seller->additional_data, true);
        return view('admin.dashboard.seller_details', compact('seller', 'data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $data = json_decode($user->additional_data, true) ?? [];

        $data['accepted'] = 'yes';
        $data['accepted_at'] = now();
        Create_Wallet($id);
        $user->additional_data = json_encode($data);
        
        $user->save();
        return redirect()->route('admin.sellers.index')->with('success', 'Seller accepted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

