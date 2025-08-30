<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PaidReservation;
use App\Models\notifications;
use Carbon\Carbon;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now()->startOfDay();
        $threeDaysLater = $now->copy()->addDays(3);
    
        $reservations = PaidReservation::whereHas('offering', function ($query) use ($threeDaysLater) {
                $query->whereDate('start_time', '=', $threeDaysLater);
            })
            ->with(['offering', 'user'])
            ->get();
    
        foreach ($reservations as $reservation) {
            $user = $reservation->user;
            $offering = $reservation->offering;
    
            if (!$user || !$offering) {
                continue;
            }
    
            $additionalData = $reservation->additional_data ?? [];
            if (is_string($additionalData)) {
                $additionalData = json_decode($additionalData, true) ?? [];
            }
    
            if ($additionalData['reminder_sent_flag'] === true) {
                return;
            }
            //dd(1);
            notifcate(
                $user_id = $reservation->user_id,
                $title   = 'تذكير بالفعالية',
                $message = 'تبقى 3 أيام بالضبط على فعاليتك: ' . $offering->name,
                $additional_data = json_encode([
                    //'link' => route('merchant.reservations.show', ['id' => $reservation->id]),
                ]),
            );
            //dd(2);
    
            $additionalData['reminder_sent_flag'] = true;
            $reservation->additional_data = $additionalData;
            $reservation->save();
        }
    }
    
    
}
