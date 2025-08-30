<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant\Offer;
use App\Models\Offering;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Models\Merchant\Branch;
use Illuminate\Support\Facades\Storage;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($merchantid = null)
    {
        if(is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending' && !isset($merchantid)){
            //session()->regenerate();
            return redirect()->route("merchant.dashboard.work_center.index");
            
        }
        // if ($merchant != null) {
        //     $role = Role::findOrFail(Auth::guard('merchant')->user()->additional_data['role'] ?? 0);
        //     if (!$role->permissions->contains('key', 'services_view')) {
        //         abort(403, 'Unauthorized action.');
        //     }
        // }
        //dd($merchantid);
        $finalID = can_enter($merchantid,"offers_view");

        $offers = Offering::where('user_id', $finalID)->get();
        clear_offers($offers);
        //dd($offers);
        $branches = Branch::where("user_id", $finalID)->get(); 

        return view('merchant.dashboard.offers.index', compact('offers','branches','merchantid','finalID'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($merchantid = null)
    {
            // $role = Role::findOrFail(Auth::guard('merchant')->user()->additional_data['role'] ?? 0);
            // if (!$role->permissions->contains('key', 'services_actions')) {
            //     abort(403, 'Unauthorized action.');
            // }
            $finalID = can_enter($merchantid,"offers_create");

            $offering =  \App\Models\Offering::create([
                'user_id' => $finalID,
                'status' => "inactive",
            ]);
            //return view('merchant.dashboard.offers.edit',compact('offering'));
            if ($merchantid){
                return redirect()->route('merchant.dashboard.m.offer.edit', ['merchant' => $merchantid, 'offer' => $offering->id])->with('success', 'Offer created successfully. Please fill in the details.');

            }else{
                return redirect()->route('merchant.dashboard.offer.edit', $offering->id)->with('success', 'Offer created successfully. Please fill in the details.');

            }
        // } else {
        //     $offering =  \App\Models\Offering::create([
        //         'user_id' => Auth::id(),
        //         'status' => "inactive",
        //     ]);
        //     //return view('merchant.dashboard.offers.edit',compact('offering'));

        

        // return view('merchant.dashboard.offers.create',compact('offering'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'nullable|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:events,conference,restaurant,experiences',
            'category' => 'nullable|string|in:vip,one_day,several_days,reapeted',
            'has_chairs' => 'nullable|in:on,1,true',
            'chairs_count' => 'required_if:has_chairs,on|required_if:has_chairs,1|required_if:has_chairs,true|integer|min:0',
            //'user_id' => 'required|exists:users,id',

        ]);
        //dd($validated);
        $profilePicturePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uniqueName = 'image_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $profilePicturePath = $file->storeAs('', $uniqueName, 'public');
        }
        $has_chairs = false;
        if ($validated['has_chairs'] == 'ON') {
            $has_chairs = true;
        }
        $offer = Offering::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'image' => $profilePicturePath,
            'price' => $validated['price'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'additional_data' =>  null,
            'translations' =>  null,
            'has_chairs' => $has_chairs,
            'chairs_count' => $validated['chairs_count'],
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('merchant.dashboard.offer.index')->with('success', 'Offer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return view('merchant.offers.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$merchantid = null)
    {
        if($merchantid != null){
            $tmp = $merchantid;
            $merchantid = $id;
            $id = $tmp;
        }
        //dd(["id" => $id,"mer"=> $merchant]);
        $finalID = can_enter($merchantid,"offers_create");

        // dd($id,$merchant);
        $offering = Offering::findOrFail($id);
        if ($offering->user_id == $finalID) {
            //if ($merchant != null)
                // return redirect()->route('merchant.dashboard.m.offer.index',['merchant'=>$merchant])->with('error', 'Unauthorized action.');
            
            return view('merchant.dashboard.offers.edit', compact('offering', 'merchantid', 'finalID'));

            // return redirect()->route('merchant.dashboard.offer.index')->with('error', 'Unauthorized action.');
        }elseif ($offering->user_id != $finalID){
            $finalID = can_enter($merchantid,"offers_edit");
            return view('merchant.dashboard.offers.edit', compact('offering', 'merchantid', 'finalID'));


        }
        //return view('merchant.dashboard.offers.edit', compact('offering'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $offer = Offering::findOrFail($id);

        // تحويل قيمة checkbox
        $request->merge([
            'has_chairs' => $request->has('has_chairs'),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'nullable|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:event,conference,restaurant,experience,events,conferences,experiences',
            'category' => 'nullable|in:vip,one_day,several_days,reapeted',
            'has_chairs' => 'boolean',
            'chairs_count' => 'required_if:has_chairs,true|integer|min:0',
        ]);

        $input = $request->only([
            'name',
            'location',
            'description',
            'price',
            'start_time',
            'end_time',
            'status',
            'type',
            'category',
            'has_chairs',
            'chairs_count',
        ]);

        if ($request->hasFile('image')) {
            $input['image'] = $request->file('image')->store('offers', 'public');
        }

        $offer->update($input);

        return redirect()->route('merchant.dashboard.offer.index')->with('success', 'تم تحديث الخدمة بنجاح.');
    }


    public function destroy($id , $merchantid = null)
    {
        if($merchantid != null){
            $tmp = $merchantid;
            $merchantid = $id;
            $id = $tmp;
        }
        $finalID = can_enter($merchantid,"offers_delete");

        $offer = Offering::findOrFail($id);
        //dd($id,$merchantid,$finalID,$offer->user_id);

        if ($offer->user_id != $finalID) {
            return redirect()->route('merchant.dashboard.offer.index')->with('error', 'Unauthorized action.');
        }
        if ($offer->image) {
            Storage::disk('public')->delete($offer->image);
        }
        $offer->delete();
         if ($merchantid) {
            return redirect()->route('merchant.dashboard.m.offer.index', ["merchant" => $merchantid])->with('success', 'Offer deleted successfully.');

         }else{
            return redirect()->route('merchant.dashboard.offer.index')->with('success', 'Offer deleted successfully.');

         }    
    
    }
}
