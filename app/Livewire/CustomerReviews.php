<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer_Ratings;
use App\Models\User;
class CustomerReviews extends Component
{
    public $reviews;
    public $replyText = [];
    public $editingReply = [];
    public $finalID = null;
    public $merchantid = null;
    public function mount($finalID,$merchantid= null)
    {
        $this->merchantid = $merchantid;
        $this->finalID = $finalID;
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $user = User::find($this->finalID);

        // $this->reviews = Customer_Ratings::whereHas('offer', function($q) use ($user) {
        //     $q->where('user_id', $user->id);
        // })
        // ->where('is_visible', true)
        // ->orderByDesc('created_at')
        // ->get();
        // $this->reviews = Customer_Ratings::where('is_visible', true)
        //     ->orderByDesc('created_at')
        //     ->get();
        $this->reviews = $user->reviews()
        ->where('is_visible', true)
        ->orderByDesc('created_at')
        ->get();
    }

    public function startEditing($reviewId)
    {

        $this->editingReply[$reviewId] = true;

        $review = Customer_Ratings::find($reviewId);
        if ($review) {
            $data = is_array($review->additional_data)
                ? $review->additional_data
                : (is_string($review->additional_data) ? json_decode($review->additional_data, true) : []);
            $this->replyText[$reviewId] = $data['reply'] ?? '';
        }
    }

    public function cancelEditing($reviewId)
    {
        $this->editingReply[$reviewId] = false;
        $this->replyText[$reviewId] = '';
    }

    public function sendReply($reviewId)
    {
        if ($this->merchantid && has_Permetion($this->finalID, 'ratings_reply',$this->merchantid)) {
            return;
        }
        $reply = trim($this->replyText[$reviewId] ?? '');

        if ($reply) {
            $review = Customer_Ratings::find($reviewId);

            if ($review) {
                $data = is_array($review->additional_data)
                    ? $review->additional_data
                    : (is_string($review->additional_data) ? json_decode($review->additional_data, true) : []);

                $data['reply'] = $reply;
                $review->additional_data = $data;
                $review->save();
            }
        }

        $this->editingReply[$reviewId] = false;
        $this->replyText[$reviewId] = '';
        $this->loadReviews();
    }

    public function hideReview($reviewId)
    {
        $review = Customer_Ratings::find($reviewId);
        if ($review) {
            $review->is_visible = false;
            $review->save();
        }

        $this->loadReviews();
    }

    public function render()
    {
        return view('livewire.customer-reviews');
    }
}
