<?php

namespace App\Observers;

use App\Models\Offering;

class OfferingObserver
{
    /**
     * Handle the Offering "created" event.
     */
    public function created(Offering $offering): void
    {
        //
    }

    /**
     * Handle the Offering "updated" event.
     */
    public function updated(Offering $offering): void
    {
        if ($offering->isDirty()) {
            $data = $offering->additional_data;
            $data['is_published'] = false;
            $offering->additional_data = $data;
            $offering->saveQuietly();

            //$offering->additional_data["is_published"] = false;
            //$offering->save();
        }
    }

    /**
     * Handle the Offering "deleted" event.
     */
    public function deleted(Offering $offering): void
    {
        //
    }

    /**
     * Handle the Offering "restored" event.
     */
    public function restored(Offering $offering): void
    {
        //
    }

    /**
     * Handle the Offering "force deleted" event.
     */
    public function forceDeleted(Offering $offering): void
    {
        //
    }
}
