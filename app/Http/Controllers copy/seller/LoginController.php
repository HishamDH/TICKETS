<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('seller.auth.login');
    }
    public function register()
    {
        return view('seller.auth.register');
    }

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
        if($user->role !== 'seller') {
            return redirect()->back()->withErrors(['email' => 'You are not authorized to access this area'])->withInput();
        }
        if ($user && Hash::check($validated['password'], $user->password)) {
            auth()->login($user);
            return redirect()->route('seller.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }
    public function register_logic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:seller,restaurant',
            'image' => 'nullable|image|max:2048',
        ]);
        
        if ($request->role === 'restaurant') {
            $validator->addRules([
                'phone' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'open_at' => 'nullable',
                'close_at' => 'nullable',
                'table' => 'nullable',
                'location' => 'nullable|string',
                'hour_price' => 'nullable|numeric',
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
                'hour_price' => $validated['hour_price'] ?? null,
                'table' => $validated['table'] ?? null,
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
        return redirect()->route('seller.dashboard')->with('success', 'Login successful');
    }
}
