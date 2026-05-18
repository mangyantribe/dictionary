<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\WordService;
use Flux\Flux;
new class extends Component
{
    protected $wordService;
    public $addWordModal = false;
    public $word;

    public function boot(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    #[On('add-word')] 
    public function addWord()
    {   
        $this->resetFields();
        $this->addWordModal = true;
    }

    #[On('edit-word')]
    public function editWord($id)
    {
        $word = $this->wordService->findWord($id);
        $this->word =  $word->word;
        $this->addWordModal = true;
    }

    public function saveWord()
    {
        $this->validate([
            'word' => 'required'
        ]);

        $data = (object) [
            'word' => $this->word,
        ];

        $results = $this->wordService->saveWord($data);

        if ($results) {
            Flux::toast( variant: 'success', heading:'Created', text: 'New word has been added.');
            $this->dispatch('refresh-words');
            $this->resetFields();
            $this->addWordModal = false;

        } else {
            Flux::toast(variant: 'danger', heading: 'Error',text: 'Something went wrong!');
        }
    }

    public function resetFields()
    {
        $this->reset(['word']);
    }
};
?>

<flux:modal wire:model.self="addWordModal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Save Word</flux:heading>
        </div>

        <flux:input wire:model="word" label="Word" placeholder="Word"/>

        <div class="flex">
            <flux:spacer />
            <flux:button wire:click="saveWord" variant="primary">Save changes</flux:button>
        </div>

    </div>
</flux:modal>