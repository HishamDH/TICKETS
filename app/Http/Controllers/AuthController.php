<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
        $rules = [
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
            'country_code' => [
                'required',
                'string',
                'regex:/^\+\d{1,4}$/', // مثل +966 أو +1
            ],
            'phone' => ['required', 'regex:/^[0-9\s-]{7,20}$/'],
        ];

        if (Route::is('signup')) {
            $rules['business_name'] = 'required|string|max:255';
            $rules['business_type'] = 'required|in:restaurant,events,show,other';
            $rules['other_business_type'] = 'nullable|required_if:business_type,other|string|max:255';
        }

        $validated = $request->validate($rules);
        $cleanPhone = preg_replace('/\D/', '', $request->phone);
        $fullPhone = $validated['country_code'] . $cleanPhone;
        if (User::where('phone', $fullPhone)->exists()) {
            return back()->withErrors(['phone' => 'رقم الهاتف مستخدم بالفعل.'])->withInput();
        }
        $validated['phone'] = $fullPhone;


        unset($validated['country_code']);

        // تشفير كلمة المرور
        $validated['password'] = Hash::make($validated['password']);

        // دور المستخدم
        if (Route::is('signup')) {
            $validated['additional_data'] = [
                'other_business_type' => $request->business_type === 'other' ? $request->other_business_type : null,
            ];
            $validated['role'] = 'merchant';
        } elseif (Route::is('customer.signup')) {
            $validated['role'] = 'user';
        }

        $user = User::create($validated);

        // تسجيل الدخول وتوجيه
        if ($validated['role'] === 'user') {
            Auth::guard('customer')->login($user);
            session(['email' => $user->email]);
            //return redirect()->route('otpConfermation.index')->with('success', 'Registration successful!');
            return redirect()->intended()->with('success', 'Registration successful!');

        } elseif ($validated['role'] === 'merchant') {
            session(['email' => $user->email]);
            return redirect()->route('otpConfermation.index')->with('success', 'Registration successful!');
        }

        return redirect()->intended(route('login', ['redirect' => $request->redirect ?? '']))
            ->with('success', 'تم التسجيل بنجاح!');
    }


    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($request->guard == 'admin') {
            if (Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']))) {
                session()->regenerate();
                return redirect()->intended(route('admin.dashboard.overview'))->with('success', 'Login successful');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        } elseif ($request->guard == 'merchant') {
            if (Auth::guard('merchant')->attempt(array_merge($credentials, ['role' => 'merchant']))) {
                if (Auth::guard('merchant')->user()->status == 'active' ?? false) {
                    session()->regenerate();
                    return redirect()->intended(route('merchant.dashboard.overview'))->with('success', 'Login successful');
                } else {
                    if(is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending' && !isset($merchantid)){
                        session()->regenerate();
                        return redirect()->route("merchant.dashboard.work_center.index");
                        
                    }
                    $status = Auth::guard('merchant')->user()->status;
                    Auth::guard('merchant')->logout();
                    return redirect()->route('status')->with([
                        'status' => $status,
                    ]);
                    // return back()->withErrors([
                    //     'email' => 'Your account is not accepted yet. Please wait for approval.',
                    // ]);
                }
            } else
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        } elseif ($request->guard == 'customer') {
            if (Auth::guard('customer')->attempt(array_merge($credentials, ['role' => 'user']))) {
                // session()->regenerate();
                unset($request['_token']);
                unset($request['email']);
                unset($request['password']);
                //dd($request->input('back'));
                $redirectUrl = $request->input('back') ?? route('customer.dashboard.overview');

                // $params = http_build_query($request->all());
                // $baseUrl = $request->redirect ?? route('customer.dashboard.overview');
                // $redirectUrl = $baseUrl . (str_contains($baseUrl, '?') ? '&' : '?') . $params;

                return redirect($redirectUrl)->with('success', 'Login successful');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    // public function userLogin(Request $request)
    // {
    //     $credentials =  $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     //$credentials = $request->only('email', 'password');
    //     if (Auth::guard('customer')->attempt($credentials)) {
    //         session()->regenerate();
    //         return redirect()->intended($request->redirect ?? route('customer.dashboard.overview'))->with('success', 'Login successful');
    //     }
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

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

    public function update(Request $request, string $id, $merchantid = null)
    {
        if ($merchantid != null) {
            $tmp = $merchantid;
            $merchantid = $id;
            $id = $tmp;
        }
        $finalID = can_enter($merchantid, "settings_edit");
        if ($finalID != $id) {
            abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
        }

        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url|max:255',
        ]);

        $user = User::findOrFail($id);

        $data = is_array($user->additional_data)
            ? (object) $user->additional_data
            : (object) (json_decode($user->additional_data, true) ?? []);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $uniqueName = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $profilePicturePath = $file->storeAs('', $uniqueName, 'public');

            if (!empty($data->profile_picture)) {
                Storage::disk('public')->delete($data->profile_picture);
            }

            $data->profile_picture = $profilePicturePath;
        }

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $uniqueName = 'banner_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $bannerPath = $file->storeAs('', $uniqueName, 'public');

            if (!empty($data->banner)) {
                Storage::disk('public')->delete($data->banner);
            }

            $data->banner = $bannerPath;
        }

        if ($request->filled('social_links')) {
            $data->social_links = array_filter($request->input('social_links', []));
        }

        $user->additional_data = (array) $data;
        $user->save();

        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }

    public function update_settings(Request $request, string $id, $merchantid = null)
    {
        if ($merchantid != null) {
            $tmp = $merchantid;
            $merchantid = $id;
            $id = $tmp;
        }
        $finalID = can_enter($merchantid, "settings_edit");

        if ($finalID != $id) {

            abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
        }

        //dd($request->all());
        $validated = $request->validate([
            // 'f_name' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     'regex:/^[\pL\s\-]+$/u',
            // ],
            // 'l_name' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     'regex:/^[\pL\s\-]+$/u',
            // ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                //'unique:users,email,' . $id,
            ],
            //dd(1),
            'phone' => ['required', 'max:16', 'regex:/^[^a-zA-Z.]+$/'],

        ]);


        $user = User::findOrFail($id);
        //$user->f_name = $validated["f_name"];
        //$user->l_name = $validated["l_name"];

        $data = $user->additional_data;
        $data['page_email'] = $validated["email"];

        $user->additional_data = $data;
        $user->phone = $validated["phone"];
        $user->save();
        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }
    public function update_PS(Request $request, string $id)
    {
        if (Auth::guard("merchant")->user()->id != $id) {

            abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
        }

        //dd($request->all());
        $validated = $request->validate([
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


        ]);


        $user = User::findOrFail($id);
        $user->f_name = $validated["f_name"];
        $user->l_name = $validated["l_name"];

        $user->save();
        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }
    public function update_password(Request $request, string $id)
    {
        if (Auth::guard('merchant')->user()->id != $id) {
            abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
        }
        //dd($request->all());Abc@123111

        $validated = $request->validate([
            'old_password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],
        ]); //Abc@123111
        $user = User::findOrFail($id);

        if (!Hash::check($validated["old_password"], $user->password)) {
            return back()->with('error', 'كلمة المورو القديمة غير مطابقة.');
        }
        $user->password = Hash::make($validated["password"]);
        $user->save();
        return back()->with('success', 'تم تحديث البيانات بنجاح.');
    }

    public function update_work(Request $request, string $id, $merchantid = null)
    {
        if ($merchantid != null) {
            $tmp = $merchantid;
            $merchantid = $id;
            $id = $tmp;
        }
        $finalID = can_enter($merchantid, "settings_edit");

        if ($finalID != $id) {
            abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
        }
        //dd($request->all());Abc@123111

        $validated = $request->validate([
            'business_name' => [
                'required',
                'string',
                'max:32'
                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            ],
            'business_type' => [
                'required',
                'string',
                'in:events,restaurant,show,other',

                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                //'confirmed',
            ],
            'other_business_type' => [
                'required_if:business_type,other',
                'nullable',
                'string',
                'max:20',
            ],

        ]); //Abc@123111
        $user = User::findOrFail($id);


        $user->business_name = $validated["business_name"];
        $user->business_type = $validated["business_type"];

        if ($validated["other_business_type"]) {
            $data = $user->additional_data;
            $data['other_business_type'] = $validated["other_business_type"];

            $user->additional_data = $data;
        }
        //dd(1);
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
        Auth::guard('merchant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function userLogout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
    public function dashboard()
    {
        // dd('hi');
        if (Auth::guard('merchant')->user() && Auth::guard('merchant')->user()->role = 'merchant') {
            return redirect()->route('merchant.dashboard.overview');
        }
        if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->role = 'user')
            return redirect()->route('customer.dashboard.overview');
        return redirect()->route('login');
    }
}
