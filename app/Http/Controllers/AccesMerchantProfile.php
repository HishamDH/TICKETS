<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AccesMerchantProfile extends Controller
{
    public function index()
    {

        if(!Auth::guard('admin')->check()){
            abort(403, 'Unauthorized action.');
        }
        $merchants = User::where('role', 'merchant')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //return redirect()->route("merchant.dashboard.m.overview");
        return view("admin.dashboard.merchants",compact('merchants'));
    }
}
