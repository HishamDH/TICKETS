<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('employee.auth.login');
    }
    // public function register()
    // {
    //     return view('employee.auth.register');
    // }

    public function login_logic(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
        if($user->role !== 'employee') {
            return redirect()->back()->withErrors(['email' => 'You are not authorized to access this area'])->withInput();
        }
        if ($user && Hash::check($validated['password'], $user->password)) {
            auth()->login($user);
            return redirect()->route('employee.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }
    // public function register_logic(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|confirmed',
    //     ]);
    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']),
    //         'role' => 'employee',
    //     ]);
    //     auth()->login($user);
    //     return redirect()->route('employee.dashboard')->with('success', 'Login successful');
    // }
}
