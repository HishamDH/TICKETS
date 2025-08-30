<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($merchantid = null)
    {
        $finalID = can_enter($merchantid,"branches_view");
        if(is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending' && !isset($merchantid)){
            //session()->regenerate();
            return redirect()->route("merchant.dashboard.work_center.index");
            
        }
        //$user = Auth::guard('merchant')->user();
        $user = User::find($finalID);
        $branches = $user->branches()->paginate(10);
        return view('merchant.dashboard.branch.index', compact('branches','merchantid','finalID'));
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
    public function store(Request $request,$merchantid = null)
    {
        //$user = Auth::guard('merchant')->user();
        //dd($merchantid);
        $finalID = can_enter($merchantid,"branches_create");

        $user = User::find($finalID);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $user->branches()->create($request->only(['name', 'location']));
        // Branch::create($request->only(['name', 'location']));
        return redirect()->back()->with('success', 'تم إضافة الفرع بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $merchantid = null,$branch = null)
    {   //dd($branch,$merchantid);
        if ($branch === null) {
            $branch = $merchantid;
            $merchantid = null;
        }
        $finalID = can_enter($merchantid,"branches_edit");

        $user = User::find($finalID);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $branch = $user->branches()->findOrFail($branch);
        $branch->name = $validated['name'];
        $branch->location = $validated['location'];
        $branch->save();
        return redirect()->back()->with('success', 'تم تعديل الفرع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($merchantid = null,$branch = null)
    {


        if ($branch === null) {
            $branch = $merchantid;
            $merchantid = null;
        }
        $finalID = can_enter($merchantid,"branches_delete");
        //dd($branch,$merchantid);

        $user = User::find($finalID);
        $branch = $user->branches()->findOrFail($branch);
        $branch->delete();
        return redirect()->back()->with('success', 'تم حذف الفرع بنجاح');
    }
}
