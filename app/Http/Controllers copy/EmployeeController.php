<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {

        $employees = User::whereIn('role', ['admin','employee','checker'])->get();

        return view('admin.dashboard.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    
    {
        $usedRoles = [
            'admin',
            'employee',
            'checker',
        ];
        return view('admin.dashboard.employees.create',compact('usedRoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$usedRoles = User::select('role')->distinct()->pluck('role')->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,employee,checker'

        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' =>  $validated['role']
        ]);

        return redirect()->route('admin.employees.index')->with("success",'employee was changed role');

    }
    public function change(Request $request,string $id){

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
        $usedRoles = [
            'admin',
            'employee',
            'checker',
        ];
        $employee = User::findOrFail($id);

        return view('admin.dashboard.employees.edit',compact('employee','usedRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,employee,checker'

        ]);

        
        $employee->update($validated);
        return redirect()->route('admin.employees.index')->with("success",'employee was changed role');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->id == $id){
            return redirect()->route('admin.employees.index')->with("fail",'employee can not changed role');
        }else{
            $user = User::findOrFail($id);
            $user->role = "visitor";
            $user->save();
        }
        return redirect()->route('admin.employees.index')->with("success",'employee was changed role');
    }
}
