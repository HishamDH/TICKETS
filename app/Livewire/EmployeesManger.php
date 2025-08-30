<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeesManger extends Component
{
    public $admins;

    // فورم الإضافة
    public $f_name, $l_name, $email, $password;
    public $permissions = [
        'employees_edit' => false,
        'merchants_access' => false,
        'staff_approval' => false,
        'withdraw_check' => false,
        'tickets' => false,
        //'system_edit' => false,

    ];

    protected $rules = [
        'f_name' => 'required|string|min:2',
        'l_name' => 'required|string|min:2',
        'email'  => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function mount()
    {
        //dd(adminPermission("employees_edit"));
        if (Auth::guard("admin")->user() === null) {
            abort(403, 'Unauthorized action.');
        }
        $this->loadAdmins();
    }

    public function loadAdmins()
    {
        //dd(LoadConfig());
        $owner = LoadConfig()->system->owner ?? null;
        $this->admins = User::where('role', 'admin')->where('id', '!=', $owner)->get();
    }

    public function addAdmin()
    {
        if (!adminPermission("employees_edit")) {
            session()->flash('error', 'ليس لديك صلاحية لإضافة أدمن جديد ❌');
            return;
        }
        $this->validate();

        $user = User::create([
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email'  => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'admin',
            'additional_data' => [
                'permissions' => $this->permissions,
            ],
        ]);

        $this->reset(['f_name','l_name','email','password']);
        $this->permissions = [
            'employees_edit' => false,
            'merchants_access' => false,
            'staff_approval' => false,
            'withdraw_check' => false,
            'tickets' => false,
            //'system_edit' => false,
    
        ];

        $this->loadAdmins();
        session()->flash('success','تمت إضافة الأدمن بنجاح ✅');
    }

    public function deleteAdmin($id)
    {
        if (!adminPermission("employees_edit")) {
            session()->flash('error', 'ليس لديك صلاحية لحذف الأدمن ❌');
            return;
        }
        $admin = User::findOrFail($id);
        $admin->delete();
        $this->loadAdmins();
        session()->flash('success','تم حذف الأدمن ❌');
    }

    public function togglePermission($id, $perm)
    {
        if (!adminPermission("employees_edit")) {
            session()->flash('error', 'ليس لديك صلاحية لتعديل الصلاحيات ❌');
            return;
        }
        $admin = User::findOrFail($id);
        $data = $admin->additional_data ?? [];

        if (!isset($data['permissions'])) {
            $data['permissions'] = [];
        }

        $current = $data['permissions'][$perm] ?? false;
        $data['permissions'][$perm] = !$current;

        $admin->additional_data = $data;
        $admin->save();

        $this->loadAdmins();
    }

    public function render()
    {
        return view('livewire.employees-manger');
    }
}
