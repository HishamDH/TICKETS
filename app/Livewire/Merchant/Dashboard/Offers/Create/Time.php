<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;
use Livewire\Component;
use App\Models\Offering;
use Carbon\Carbon;

class Time extends Component
{
    public Offering $offering;

    public bool $enable_time = true;
    public $day = [];
    public $from_time = [];
    public $to_time = [];
    public $calendar = [];
    public $default_day = [
        'enabled' => false,
        'from' => null,
        'to' => null,
    ];
    public $max_reservation_date;
    public $active_max_reservation_date;

    
    public function mount()
    {
        if ($this->offering->features) {
            $features = $this->offering->features;
    
            $this->enable_time = $features['enabled'] ?? true;
    
            if ($this->offering->type == 'services') {
                $this->active_max_reservation_date = $features['active_max_reservation_date'] ?? null;
                $this->max_reservation_date = $features['max_reservation_date'] ?? null;
                $this->day = [
                    'saturday' => false,
                    'sunday' => false,
                    'monday' => false,
                    'tuesday' => false,
                    'wednesday' => false,
                    'thursday' => false,
                    'friday' => false,
                ];
    
                $this->from_time = [];
                $this->to_time = [];
    
                if (isset($features['days'])) {
                    foreach ($features['days'] as $dayName => $dayData) {
                        if (array_key_exists($dayName, $this->day)) {
                            $this->day[$dayName] = true;
                            $this->from_time[$dayName] = $dayData['from'] ?? '';
                            $this->to_time[$dayName] = $dayData['to'] ?? '';
                        }
                    }
                }
            }
    
            if ($this->offering->type == 'events') {
                $this->calendar = $features['calendar'] ?? [];
            }
        } else {
            // القيم الافتراضية
            $this->day = [
                'saturday' => false,
                'sunday' => false,
                'monday' => false,
                'tuesday' => false,
                'wednesday' => false,
                'thursday' => false,
                'friday' => false,
            ];
        }
    }

    public function addEvent()
    {
        $this->calendar[] = [
            'date' => '',
            'start_time' => '',
            'end_time' => '',
        ];
    }

    public function removeEvent($index)
    {
        unset($this->calendar[$index]);
        $this->calendar = array_values($this->calendar);
        $this->save();
    }
    public function save()
    {
        $features = $this->offering->features ?? [];
    
        $features['enabled'] = $this->enable_time;
        $features['active_max_reservation_date'] = $this->active_max_reservation_date ?? null;
        if ($this->active_max_reservation_date){
            $features['max_reservation_date'] = $this->max_reservation_date ?? null;
        }else{
            $features['max_reservation_date'] = Carbon::parse("3000-12-31");
        }
        if ($this->offering->type == 'services') {
            $features['type'] = 'service';
            $features['days'] = [];
    
            foreach ($this->day as $dayName => $enabled) {
                if ($enabled && isset($this->from_time[$dayName]) && isset($this->to_time[$dayName])) {
                    $features['days'][$dayName] = [
                        'from' => $this->from_time[$dayName],
                        'to' => $this->to_time[$dayName],
                    ];
                }
            }
        }
    
        $features['calendar'] = array_values(array_filter($this->calendar, function ($event) {
            return !empty($event['start_date']) && !empty($event['end_date']) && !empty($event['start_time']) && !empty($event['end_time']);
        }));
    
        $this->offering->features = $features;
        $this->offering->save();
    
        $this->dispatch('saved');
    }
    
    public function applyDefaultToAll()
    {
        if ($this->default_day['enabled']) {
            foreach (['saturday','sunday','monday','tuesday','wednesday','thursday','friday'] as $d) {
                $this->day[$d] = true;
                $this->from_time[$d] = $this->default_day['from'];
                $this->to_time[$d] = $this->default_day['to'];
            }
        }

        $this->save();


    }
    public function updated() {
        $this->save();
     }

    public function render()
    {

        return view('livewire.merchant.dashboard.offers.create.time');
    }
}
