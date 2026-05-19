<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\WordService;
use App\Services\CountryService;
use Livewire\Attributes\Computed;
new #[Layout('layouts::guest')] class extends Component
{
    protected $wordService;

    public $search;
    public string $id;
    public string $country;

    public function boot(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    #[Computed]
    public function words()
    {
        return $this->wordService->getCountryWords($this->id);
    }

    public function showDetails($id)
    {
        dd($id);
    }   
};
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900 px-4">
    <div class="w-full max-w-lg">
        <div class="-mx-2 -mt-2">
            <flux:tooltip content="Back">
                <flux:button href="/" variant="ghost" size="sm" icon="arrow-left" inset="top right bottom" />
            </flux:tooltip>
        </div>
        <flux:card class="space-y-4 flex flex-col items-center">

            <flux:heading size="lg" class="flex items-center justify-center gap-2">
                <flux:icon.flag /> 
                {{ ucfirst($this->country) }}
            </flux:heading>
            <flux:input wire:model.live.debounce.300ms="search" class="w-full max-w-xs" placeholder="Search word..."/>
            <div class="w-full space-y-2" wire:transition>
                @forelse($this->words as $word)
                    <flux:callout color="sky" icon="flag" heading="{{ $word['word'] }}" class="cursor-pointer" wire:click="showDetails({{ $word['id'] }})"/>
                @empty
                    <div class="text-center py-10">
                        <flux:text class="text-zinc-500">No countries found.</flux:text>
                    </div>
                @endforelse

            </div>
        </flux:card>
    </div>
</div>