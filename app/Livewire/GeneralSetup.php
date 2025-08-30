<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\setup;
use App\Models\User;
//use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Support\Facades\Auth;
class GeneralSetup extends Component
{
    use WithFileUploads;

    public $tab = 'general'; 
    public $accountTab = true;
    public $logo;
    public $setup;
    public $can_save = false;
    // Editable fields
    public $name;
    public $email;
    public $phone;
    public $social_links = [];
    public $additional_data = [];
    public $owner;
    public $first_name, $last_name, $admin_email, $password, $password_confirmation;

    public $tabs = [
        //'account'=>'👤 الحساب',
        'general'=>'⚙️ عام',
        'contact'=>'📞 تواصل',
        'social'=>'🌐 روابط اجتماعية',
        'payment'=>'💰 الدفع',
        'policy'=>'📜 سياسة الخصوصية',
        'terms'=>'📑 الشروط والأحكام'
    ];

    protected $rules = [
        'first_name' => 'required|string|min:2|max:50',
        'last_name' => 'required|string|min:2|max:50',
        'admin_email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    public function mount()
    {
        $setup = Setup::first();

        if ($setup) {

            //dd($setup->additional_data["owner"]);
            if (isset($setup->additional_data["owner"])){
                //dd(1);
                $this->tab = "general";
                $this->accountTab = false;
            
            }

            $this->setup = $setup;
            $this->owner = User::find($setup->additional_data['owner']);
            $this->first_name = $this->owner->f_name;
            $this->last_name = $this->owner->l_name;
            $this->admin_email = $this->owner->email;
            $this->password = "";
        } else {
            $this->setup = new Setup();
            $this->owner = new User();

        }
        
        $this->name = $this->setup->name;
        $this->email = $this->setup->email;
        $this->phone = $this->setup->phone;
        $this->social_links = $this->setup->social_links ?? [];
        $this->additional_data = $this->setup->additional_data ?? [];

        if ($this->accountTab) {
            $this->tabs["account"] = "👤 الحساب";
        }

    }

    public function SaveUser()
    {
        $this->validate($this->rules);
        $this->owner->f_name = $this->first_name;
        $this->owner->l_name = $this->last_name;
        $this->owner->email = $this->admin_email;
        if ($this->password) {
            $this->owner->password = bcrypt($this->password);
        }
        //$this->owner->password = bcrypt($this->password);
        $this->owner->role = 'admin';

        $this->owner->save();
        Auth::guard("admin")->login($this->owner);
        //$this->validateOnly($);
    }


    public function save()
    {
        //$this->owner = User::
        
        if(isset($this->setup->additional_data["owner"])){
            if ($this->setup->additional_data["owner"] != Auth::guard("admin")->user()->id) {
                session()->flash('error', '❌ لا يمكنك تعديل الإعدادات');
                return;
            }
        }else{
            $this->SaveUser();
            $this->additional_data["owner"] = Auth::guard("admin")->user()->id;

        }

        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            $this->setup->logo = $path;
        }

        $this->setup->fill([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'social_links' => $this->social_links,
            'additional_data' => $this->additional_data,
        ]);
        
        $this->setup->save();
        
        //$this->setup->save();

        session()->flash('success', '✅ تم حفظ الإعدادات بنجاح يرجى عمل ريفريش للموقع');
    }

    public function render()
    {
        if(!empty($this->name) && !empty($this->email) && !empty($this->phone) && !empty($this->first_name) && !empty($this->last_name) && !empty($this->admin_email)){
            $this->can_save = true;
        }else{
            $this->can_save = false;
        }
        return view('livewire.general-setup');
    }
}


