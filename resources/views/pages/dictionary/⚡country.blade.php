<?php

use Livewire\Component;

new class extends Component
{
    public function addCountry()
    {   
        $this->dispatch('add-country');
    }
};
?>

<div>
    <flux:heading  size="xl" level="1" class="flex flex-col gap-4 sm:flex-row sm:items-center">
        {{ __('Countries') }}
        <flux:spacer />
        <div class="flex w-full sm:w-auto">
            <flux:button variant="primary" wire:click="addCountry" icon="plus" class="w-full sm:w-auto">
                Add Country
            </flux:button>
        </div>
    </flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Country settings') }}</flux:subheading>
    <flux:separator variant="subtle" />
    <livewire:country.list/>
    <livewire:country.create/>
</div>