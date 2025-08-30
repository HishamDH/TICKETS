<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Offering;
use Illuminate\Support\Facades\Storage;

class Gallery extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $image;
    public $gallery = [];
    public $gallery1 = [];

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
        $this->gallery = $offering->features['gallery'] ?? [];
    }

    public function updatedImage()
    {
        $path = $this->image->store('offerings', 'public');
        $this->offering->update(['image' => $path, 'status' => 'inactive']);
        $this->dispatch('image-uploaded');
        $this->dispatch('ServiceUpdated');
    }
    public function updatedGallery1($files)
    {
        foreach ($files as $file) {
            $path = $file->store('offerings/gallery', 'public');
            $this->gallery[] = $path; // ✅ صح، هيك بنضيف فقط string
        }

        $features = $this->offering->features ?? [];
        $features['gallery'] = $this->gallery;

        $this->offering->update([
            'features' => $features,
            'status' => 'inactive'
        ]);

        $this->dispatch('gallery-updated');
        $this->dispatch('ServiceUpdated');
    }

    public function removeGalleryImage($index)
    {
        unset($this->gallery[$index]);
        $this->gallery = array_values($this->gallery);

        $features = $this->offering->features ?? [];
        $features['gallery'] = $this->gallery;

        $this->offering->update([
            'features' => $features,
            'status' => 'inactive'
        ]);
        $this->dispatch('ServiceUpdated');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.gallery');
    }
}
