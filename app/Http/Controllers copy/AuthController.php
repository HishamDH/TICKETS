<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role . '.dashboard')->with('success', 'You have been logged in successfully.');
        }
        return redirect()->route('login')->with('error', 'You must be logged in to access the dashboard.');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Login successful');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:visitor,seller,restaurant',
        ]);

        if ($request->role === 'restaurant') {
            $validator->addRules([
                'phone' => 'nullable|regex:/^[0-9+\-\s()]{8,20}$/',
                'description' => 'nullable|string|max:1000',
                'open_at' => 'required',
                'close_at' => 'required',
                'chairs_count' => 'required|integer|min:1',
                'image' => 'required|image|max:2048',
                'location' => 'nullable|string',
            ]);
        }
        $validated = $validator->validate();


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'additional_data' => json_encode([
                'phone' => $validated['phone'] ?? null,
                'description' => $validated['description'] ?? null,
                'location' => $validated['location'] ?? null,
                'chairs_count' => $validated['chairs_count'] ?? null,
                'image' => $validated['image'] ?? null,
                'open_at' => $validated['open_at'] ?? null,
                'close_at' => $validated['close_at'] ?? null,
                'accepted' => 'no',
                'accepted_at' => null,
                'acceptes_by' => null,
            ]),
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/sellers', 'public');
            $user->additional_data = json_encode(array_merge(
                json_decode($user->additional_data, true),
                ['image' => $imagePath]
            ));
            $user->save();
        }
        auth()->login($user);
        return redirect()->intended(route('dashboard'))->with('success', 'Signup done successfully');
    }
}
