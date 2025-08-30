<?php

namespace App\Livewire\Customer\Dashboard;

use Livewire\Component;

use Livewire\WithFileUploads;

class Support extends Component
{
    use WithFileUploads;

    public $subject, $category, $message, $attachment;

    public function updated($field)
    {
        $this->validateOnly($field, [
            'subject' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $this->save();
    }
    public function save()
    {
        $support = new \App\Models\Supports();

        
        $support->user_id = auth()->id();
        $support->subject = $this->subject;
        $support->category = $this->category;
        $support->message = $this->message;

        if ($this->attachment) {
            $filename = $this->attachment->store('support-attachments', 'public');
            $support->attachment = $filename;
        }

        $support->save();

        // Optionally reset inputs
        $this->reset(['subject', 'category', 'message', 'attachment']);
    }

    public function render()
    {
        return view('livewire.dashboard.support');
    }
}

