<?php

namespace App\Livewire\Customer\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class Profile extends Component
{
    use WithFileUploads;

    public $f_name, $l_name, $email, $phone, $password,$password_confirmation;
    public $image;
    public $notify_email = true;
    public $notify_sms = true;

    public function mount()
    {
        $user = Auth::user();

        $this->f_name = $user->f_name;
        $this->l_name = $user->l_name;
        $this->email = $user->email;
        $this->phone = $user->phone;

        $this->notify_email = $user->additional_data['notify_email'] ?? true;
        $this->notify_sms = $user->additional_data['notify_sms'] ?? true;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->save();
    }
    public function updatePass(){
        $password = $this->password;
        // $this->validateOnly('password', [
        //     'password' => 'nullable|string|min:8',
        // ]);
        $user = Auth::user();

        if (!empty($password)) {
            $this->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                ],
            ]);
            $user->password = Hash::make($password);
            $user->save();
            session()->flash('success', 'تم تغيير كلمة المرور بنجاح.');
            $this->reset(['password', 'password_confirmation']);
        }
        

    }

    public function save()
    {
        $user = Auth::user();
    
        $user->f_name = $this->f_name;
        $user->l_name = $this->l_name;
        $user->phone = $this->phone;
    
        // تعديل إشعارات في additional_data
        $data = $user->additional_data ?? [];
        $data['notify_email'] = $this->notify_email;
        $data['notify_sms'] = $this->notify_sms;
    
        if ($this->image) {
            $path = $this->image->store('profile-photos', 'public');
            $data['profile_picture'] = $path;
        }
    
        $user->additional_data = $data;

    
        $user->save();
    }
    

    public function render()
    {
        return view('livewire.customer.dashboard.profile');
    }
}

