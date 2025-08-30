<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function index() {}

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
        //dd($request);
        $request->validate([
            'f_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
            ],
            'l_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],
            // 'business_name' => 'nullable|string|max:255',
            // 'business_type' => 'nullable|in:restaurant,events,show,other',
            // 'phone' => 'nullable|string|max:15|unique:users',
            'country_code' => ['required', 'in:+1,+966,+971,+20'],
            'phone' => ['required', 'regex:/^[0-9\s-]{7,20}$/'],
            // 'other_business_type' => 'nullable|required_if:business_type,other|string|max:255',
        ]);
        $fullPhone = $request->country_code . ltrim($request->phone, '0');

        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'business_name' => $request->business_name,
            // 'business_type' => $request->business_type,
            'phone' => $fullPhone,
            'additional_data' => [
                // 'other_business_type' => $request->business_type === 'other' ? $request->other_business_type : null,

            ],
            'role' => 'user',

        ]);

        //Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //$credentials = $request->only('email', 'password');
        if (Auth::guard('merchant')->attempt($credentials)) {
            //Auth::login();
            //dd(auth()->user());
            if (Auth::guard('merchant')->is_accepted == true) {
                session()->regenerate();
                return redirect()->intended(route('merchant.dashboard.overview'))->with('success', 'Login successful');
            } else {
                Auth::guard('merchant')->logout();
                return back()->withErrors([
                    'email' => 'Your account is not accepted yet. Please wait for approval.',
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

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

        public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url|max:255',
        ]);

        $user = User::findOrFail($id);

        // decode existing data safely
        $data = is_array($user->additional_data)
            ? (object) $user->additional_data
            : (object) (json_decode($user->additional_data, true) ?? []);

        // ✅ تحديث صورة البروفايل فقط إذا تم رفع صورة جديدة
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $uniqueName = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $profilePicturePath = $file->storeAs('', $uniqueName, 'public');

            // حذف القديم إن وجد
            if (!empty($data->profile_picture)) {
                Storage::disk('public')->delete($data->profile_picture);
            }

            $data->profile_picture = $profilePicturePath;
        }

        // ✅ تحديث البانر فقط إذا تم رفعه
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $uniqueName = 'banner_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $bannerPath = $file->storeAs('', $uniqueName, 'public');

            if (!empty($data->banner)) {
                Storage::disk('public')->delete($data->banner);
            }

            $data->banner = $bannerPath;
        }

        // ✅ تحديث روابط التواصل فقط إذا وصلت قيمة
        if ($request->filled('social_links')) {
            $data->social_links = array_filter($request->input('social_links', []));
        }

        // ✅ حفظ json بدون تغيير القيم غير المعدلة
        $user->additional_data = (array) $data;
        $user->save();

        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function dashboard()
    {
        if (Auth::guard('merchant')->user() && Auth::guard('merchant')->user()->role = 'merchant')
            return redirect()->route('merchant.dashboard.overview');
        else
            return redirect()->route('login');
    }
}
