<?php



namespace App\Livewire\Merchant\Dashboard\Offers;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Offering;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class SetupSteps extends Component
{

    public Offering $offering;
    public int $currentStep = 1;
    public $merchantid = null , $finalID = null;

    public function mount(Offering $offering, $merchantid = null,$finalID)
    {
        $this->merchantid = $merchantid;
        $this->finalID = $finalID;  

        $this->offering = $offering;
    }


    public function setStep($step)
    {
        $this->currentStep = $step;
    }
    public function publish()
    {
        //dd('Publishing the offer...');
        $isReady = hasEssentialFields($this->offering->id);
        //dd($isReady);
        if ($isReady) {
            $offering = $this->offering;
            $data = $offering->additional_data;
            // $data['is_published'] = true;
            $offering->additional_data = $data;
            $offering->status = 'active';
            $offering->save();

            notifcate($this->finalID, 'success', 'Offer published successfully!', [
                'title' => 'Offer Published',
                'text' => 'Your offer has been published successfully.',
            ]);
        }
        $this->render();
    }
    #[On('ServiceUpdated')]
    public function render()
    {

        $off = $this->offering;
        $isPublished = $off->status;
        $isReady = true;//($this->offering->id)['status'];
        $percent_progress = 100.0;
        $fileds_exists = [];
        if ($isPublished === "inactive") {
            $isReady = hasEssentialFields($this->offering->id)['status'];
            $all_fileds = count(hasEssentialFields($this->offering->id)['fields']);
            $fileds_exists = hasEssentialFields($this->offering->id)['fields'];

            $true_fileds = count(array_filter(hasEssentialFields($this->offering->id)['fields']));
            $percent_progress = ($true_fileds / $all_fileds) * 100;
        }

        //dd($isReady = hasEssentialFields($this->offering->id));

        //dd($all_fileds, $true_fileds,$persent_progress);
        //dd($isPublished, $isReady);
        //dd(hasEssentialFields($this->offering->id)['fields']);
        //$d = fetch_time($this->offering->id);
        //dd($d);
        return view('livewire.merchant.dashboard.offers.setup-steps', compact('isReady', 'isPublished','percent_progress','fileds_exists'));
    }
}
