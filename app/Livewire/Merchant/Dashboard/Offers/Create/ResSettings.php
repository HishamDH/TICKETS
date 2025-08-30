<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use App\Models\Merchant\Branch;
use Illuminate\Support\Facades\Auth;
class ResSettings extends Component
{
    public Offering $offering;

    public bool $enable_duration = false;
    public $booking_duration = 1;
    public $booking_unit = 'hour';

    //public bool $enable_work_schedule = false;
    // public array $work_schedule = [
    //     'saturday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'sunday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'monday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'tuesday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'wednesday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'thursday' => ['enabled' => false, 'start' => '', 'end' => ''],
    //     'friday' => ['enabled' => false, 'start' => '', 'end' => ''],
    // ];

    public bool $enable_closed_days = false;
    public array $closed_days = [];
    public string $new_closed_day = '';

    public bool $enable_user_limit = false;
    public $user_limit = 1;

    public bool $enable_booking_deadline = false;
    public $booking_deadline_minutes = 30;

    public bool $enable_weekly_recurrence = false;
    public $weekly_recurrence_days = '';

    public bool $enable_max_users = false;
    public $max_user_time = 1;
    public $max_user_unit = 'hour';
    public $eventMaxQuantity = 0;

    public $type;
    
    //public $enable_selected_branches = false;
    public $branches;
    public array $selected_branches = [];
    public $finalID;
    public function mount(Offering $offering , $finalID)
    {
        $this->offering = $offering;
        $this->finalID = $finalID;
        $features = $offering->features ?? [];
        $this->type = $offering->type;
        // ✅ تأكد أن closed_days عبارة عن array دائمًا حتى لو كانت string
        if (isset($features['closed_days']) && is_string($features['closed_days'])) {
            $features['closed_days'] = array_filter(array_map('trim', explode(',', $features['closed_days'])));
        }
        if (!isset($features['selected_branches']) || !is_array($features['selected_branches'])) {
            $features['selected_branches'] = [];
        }
        
        $this->branches = Branch::where('user_id', $this->finalID)->get();
        $this->fill(array_merge([
            'enable_duration' => false,
            'booking_duration' => 1,
            'booking_unit' => 'hour',

            // 'enable_work_schedule' => false,
            // 'work_schedule' => $this->work_schedule,

            'enable_closed_days' => false,
            'closed_days' => [],
            'new_closed_day' => '',

            'enable_user_limit' => false,
            'user_limit' => 1,

            'enable_max_users' => false,
            'max_user_time' => 1,
            'max_user_unit' => 'hour',

            'enable_booking_deadline' => false,
            'booking_deadline_minutes' => 30,

            'enable_weekly_recurrence' => false,
            'weekly_recurrence_days' => '',
            //'enable_selected_branches' => false,
            'selected_branches' => [],
            'eventMaxQuantity' => 0,

        ], $features));
    }

    public function addClosedDay()
    {
        $day = trim($this->new_closed_day);

        if (
            $day &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $day) &&
            !in_array($day, $this->closed_days) &&
            strtotime($day) >= strtotime(date('Y-m-d')) // ✅ منع تواريخ الماضي
        ) {
            $this->closed_days[] = $day;
            $this->new_closed_day = '';
        }
    }

    public function removeClosedDay($index)
    {
        unset($this->closed_days[$index]);
        $this->closed_days = array_values($this->closed_days);
    }

    public function saveTimeSettings()
    {
        $features = $this->offering->features ?? [];

        $features['enable_duration'] = $this->enable_duration;
        $features['booking_duration'] = (int) $this->booking_duration;
        $features['booking_unit'] = $this->booking_unit;

        // $features['enable_work_schedule'] = $this->enable_work_schedule;
        // $features['work_schedule'] = $this->work_schedule;

        $features['enable_closed_days'] = $this->enable_closed_days;
        $features['closed_days'] = $this->closed_days;

        $features['enable_user_limit'] = $this->enable_user_limit;
        $features['user_limit'] = (int) $this->user_limit;

        $features['enable_max_users'] = $this->enable_max_users;
        $features['max_user_time'] = (int) $this->max_user_time;
        $features['max_user_unit'] = $this->max_user_unit;

        $features['enable_booking_deadline'] = $this->enable_booking_deadline;
        $features['booking_deadline_minutes'] = (int) $this->booking_deadline_minutes;

        $features['enable_weekly_recurrence'] = $this->enable_weekly_recurrence;
        $features['weekly_recurrence_days'] = $this->weekly_recurrence_days;
        $features['eventMaxQuantity'] = (int) $this->eventMaxQuantity;
        //$features['enable_selected_branches'] = $this->enable_selected_branches;
        $features['selected_branches'] = collect($this->branches)
        ->whereIn('id', $this->selected_branches)
        ->pluck('id')
        ->values()
        ->toArray();
    
        $this->offering->update([
            'features' => $features,
            'status' => 'inactive'
        ]);
        $this->dispatch('ServiceUpdated');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.res-settings');
    }
}
