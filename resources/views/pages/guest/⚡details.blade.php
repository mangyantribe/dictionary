<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\WordService;
new class extends Component
{
    protected $wordService;

    public $detailsModal = false;
    public $word;

    public function boot(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    #[On('show-details')] 
    public function showDetails($countryId,$wordId)
    {   
        $this->word = $this->wordService->getTranslation($countryId, $wordId);
        $this->detailsModal = true;
    }
};
?>

<flux:modal wire:model.self="detailsModal" flyout variant="floating">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Details</flux:heading>
        </div>
        <flux:heading>Kahulugan</flux:heading>
        <flux:text class="mt-2">{{ $word->kahulugan ?? "" }}</flux:text>

        <flux:heading>Salin(Pilipino)</flux:heading>
        <flux:text class="mt-2">{{ $word->salin ?? "" }}</flux:text>

        <flux:heading>Halimbawa</flux:heading>
        <flux:text class="mt-2">{{ $word->halimbawa ?? "" }}</flux:text>
    </div>
</flux:modal>