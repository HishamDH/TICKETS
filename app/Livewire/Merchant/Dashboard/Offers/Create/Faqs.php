<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;

class Faqs extends Component
{
    public Offering $offering;

    public $questions = [];

    public function mount(Offering $offering)
    {
        $this->offering = $offering;
        $this->questions = $offering->additional_data['questions'] ?? [];
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'translations' => [],
        ];
        $this->save();
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
        $this->save();
    }

    public function addTranslation($qIndex)
    {
        $this->questions[$qIndex]['translations'][] = [
            'lang' => '',
            'question' => '',

        ];
        $this->save();
    }

    public function removeTranslation($qIndex, $tIndex)
    {
        unset($this->questions[$qIndex]['translations'][$tIndex]);
        $this->questions[$qIndex]['translations'] = array_values($this->questions[$qIndex]['translations']);
        $this->save();
    }

    public function save()
    {
        $originalData = $this->offering->getOriginal('additional_data') ?? [];
        $originalQuestions = $originalData['questions'] ?? [];
    
        $finalQuestions = $this->questions;
    
        foreach ($originalQuestions as $index => $question) {
            if (($question['status'] ?? null) === 'critical') {
                $preservedQuestion = $question;
    
                if (isset($finalQuestions[$index]['translations'])) {
                    $preservedQuestion['translations'] = $finalQuestions[$index]['translations'];
                }
    
                $finalQuestions[$index] = $preservedQuestion;
            }
        }
    
        $data = $this->offering->additional_data ?? [];
        $data['questions'] = $finalQuestions;
    
        $this->offering->update([
            'additional_data' => $data,
            'status' => 'inactive'
        ]);
    
        $this->dispatch('ServiceUpdated');
    }
    
    
    public function updated($field)
    {
        $this->save();
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.faqs');
    }
}
