<?php

namespace App\Livewire\Customer\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserSettings extends Component
{
    public $language;
    public $payment_method_index;
    public $availability_alert;
    public $reminder_alert;

    public $cards = [];

    public function mount()
    {
        $data = Auth::user()->additional_data ?? [];

        $this->language = $data['language'] ?? 'العربية';
        $this->payment_method_index = $data['payment_method_index'] ?? null;
        $this->availability_alert = $data['availability_alert'] ?? true;
        $this->reminder_alert = $data['reminder_alert'] ?? true;
        $this->cards = $data['cards'] ?? [];

        // ضمان وجود المفاتيح داخل كل بطاقة
        $this->cards = array_map(function ($card) {
            return array_merge([
                'type' => 'credit',
                'number' => '',
                'name' => '',
                'expiry' => ''
            ], $card);
        }, $this->cards);
    }

    public function updated($property)
    {
        $data = Auth::user()->additional_data ?? [];

        $data['language'] = $this->language;
        $data['payment_method_index'] = $this->payment_method_index;
        $data['availability_alert'] = $this->availability_alert;
        $data['reminder_alert'] = $this->reminder_alert;
        $data['cards'] = $this->cards;

        Auth::user()->update(['additional_data' => $data]);
    }

    public function addEmptyCard()
    {
        $this->cards[] = [
            'type' => 'credit',
            'number' => '',
            'name' => '',
            'expiry' => ''
        ];
    }

    public function removeCard($index)
    {
        unset($this->cards[$index]);
        $this->cards = array_values($this->cards);
    }

    public function render()
    {
        return view('livewire.customer.dashboard.user-settings');
    }
}
