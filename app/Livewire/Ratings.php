<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer_Ratings;
use Illuminate\Support\Facades\Auth;

class Ratings extends Component
{
    public $id;
    public $rating = 0;
    public $review = '';
    public $visible = true;


    public function mount($id=null)
    {
        $this->id = $id;
    
        $user = Auth::guard('customer')->user();
        if ($user) {
            $existing = Customer_Ratings::where('user_id', $user->id)
                ->where('service_id', $this->id)
                ->first();

            if ($existing) {
                $this->rating = $existing->rating;
                $this->review = $existing->review ?? '';
            }
        }
    }


    
    public function hideComponent()
    {
        $this->saveRating();
        $this->visible = false;
    }
    

    private function saveRating()
    {
        $user = Auth::guard('customer')->user();
        if (!$user) {
            session()->flash('error', 'يجب عليك تسجيل الدخول لتقييم الخدمة.');
            return;
        }
        //dd($this->id);
        Customer_Ratings::updateOrCreate(
            [
                'user_id' => $user->id,
                'service_id' => $this->id,
            ],
            [
                'rating' => $this->rating,
                'review' => $this->review,
                'is_visible' => true,
                'additional_data' => json_encode(['ip' => request()->ip()]),
            ]
        );

        session()->flash('message', 'تم تحديث التقييم بنجاح!');
    }

    public function render()
    {
        return view('livewire.ratings');
    }
}
