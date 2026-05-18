<?php

use Livewire\Component;

new class extends Component
{
    public function addWord()
    {   
        $this->dispatch('add-word');
    }
};
?>

<div>
    <flux:heading  size="xl" level="1" class="flex flex-col gap-4 sm:flex-row sm:items-center">
        {{ __('Words') }}
        <flux:spacer />
        <div class="flex w-full sm:w-auto">
            <flux:button variant="primary" wire:click="addWord" icon="plus" class="w-full sm:w-auto">
                Add Word
            </flux:button>
        </div>
    </flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Words settings') }}</flux:subheading>
    <flux:separator variant="subtle" />
    <livewire:words.list/>
    <livewire:words.create/>
    <livewire:words.delete/>
</div>