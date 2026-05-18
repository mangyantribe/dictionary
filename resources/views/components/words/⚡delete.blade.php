<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\WordService;
use Flux\Flux;
new class extends Component
{
    protected $wordService;
    public $deleteWordModal = false;
    public $word;
    public $country_id;

    public function boot(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    #[On('delete-word')]
    public function deleteWord($id)
    {
        $word = $this->wordService->findWord($id);
        $this->word = $word;
        $this->deleteWordModal = true;
    }

    public function confirmDeletion()
    {
        if($this->word->delete()){
            Flux::toast( variant: 'success', heading: 'Deleted', text:'Word has been deleted.');
            $this->dispatch('refresh-words');
            $this->deleteWordModal = false;
        }
    }
};
?>

<flux:modal wire:model.self="deleteWordModal" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete {{ $word->word ?? "" }}?</flux:heading>

            <flux:text class="mt-2">
                You're about to delete this country.<br>
                This action cannot be reversed.
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button wire:click="confirmDeletion" variant="danger">Delete</flux:button>
        </div>
    </div>
</flux:modal>