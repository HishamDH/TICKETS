<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OtpConfermation extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $email = session('email');
    
        if (!$email) {
            abort(403);
        }
    
        $lastSent = session('otp_sent_at');
    
        if (!$lastSent || now()->diffInSeconds($lastSent) >= 60) {
            $otp = sendOTP($email);
    
            session([
                'otp' => $otp,
                'email' => $email,
                'otp_sent_at' => now(),
            ]);
        }
    
        return view('otpConfermation', [
            'otp' => session('otp'),
            'email' => $email,
        ]);
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
        $request->validate([
            'otp' => 'required|string',
        ]);
        //dd(session('otp'),session('email'));
        if ((string) $request->otp !== (string) session('otp')) {
            return back()->with('error', 'رمز التحقق غير صحيح.');
        }
        
    
        $user = User::where('email', session('email'))->first();
    
        if (!$user) {
            return back()->with('error', 'المستخدم غير موجود.');
        }
    
        $data = $user->additional_data ?? [];
        $data['is_verified'] = true;
    
        $user->additional_data = $data;
        $user->save();
    
        // إزالة الـ OTP من السيشن بعد الاستخدام
        session()->forget('otp');
    
        return redirect()->route('home')->with('success', 'تم التحقق من حسابك بنجاح.');
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
