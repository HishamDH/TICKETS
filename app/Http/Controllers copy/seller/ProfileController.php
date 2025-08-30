<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $additional_data = json_decode($user->additional_data, true);
        return view('seller.dashboard.profile', compact('user', 'additional_data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // أو حسب آلية جلب المستخدم عندك
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
        if ($user->role == 'restaurant') {
            // dd('hi');
            $rules['open_at'] = 'required';
            $rules['close_at'] = 'required';
            $rules['chairs_count'] = 'required|min:1';
        }
        // التحقق من البيانات
        $validated = $request->validate($rules);

        // تحديث الاسم الرئيسي
        $user->name = $validated['name'];


        // نحضّر البيانات الإضافية
        $additionalData = [
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'location' => $validated['location'], 

        ];
        if ($user->role == 'restaurant') {
            $additionalData['open_at'] = $request['open_at'];
            $additionalData['close_at'] = $request['close_at'];
            $additionalData['chairs_count'] = $request['chairs_count'];

        }
        // في حال رفع صورة جديدة
        if ($request->hasFile('image')) {
            $imagePath = Storage::disk('public')->put('restaurant_images', $request->file('image'));
            // $imagePath = $request->file('image')->store('restaurant_images', 'public');
            $additionalData['image'] = $imagePath;
        } else {
            // لو بدك تحافظ ع الصورة القديمة لو مش رفع صورة جديدة
            $existingData = json_decode($user->additional_data, true);
            if (isset($existingData['image'])) {
                $additionalData['image'] = $existingData['image'];
            }
        }

        // تخزين البيانات الإضافية كـ JSON
        $user->additional_data = json_encode($additionalData);

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::user()->delete();
        session()->regenerate();
        return redirect()->route('home')->with('success', 'Your account has been deleted successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}
//
