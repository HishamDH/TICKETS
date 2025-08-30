<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index(){
        // $merchants = User::where('role', 'merchant')->paginate(30);
        return view('admin.dashboard.merchants.index');
    }
}
