<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\CountryService;
new #[Layout('layouts::guest')] class extends Component
{
    protected $countryService;

    public $countries = [];
    public $cursor = null;
    public $search;

    public function boot(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function mount()
    {
        $this->loadCountries();
    }

    public function updatedSearch()
    {
        $this->countries = [];
        $this->cursor = null;

        $this->loadCountries();
    }

    public function loadCountries()
    {
        $result = $this->countryService->getGuestCountries($this->search,$this->cursor);
        $this->countries = array_merge($this->countries,$result['data']); 
        $this->cursor = $result['cursor'];
    }

    public function loadMore()
    {
        if (!$this->cursor) return;

        $this->loadCountries();
    }
};
?>


<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900 px-4">
    <div class="w-full max-w-lg">

        <flux:card class="space-y-4 flex flex-col items-center">
            <flux:input wire:model.live.debounce.300ms="search" class="w-full max-w-xs" placeholder="Search country"/>
            <div class="w-full space-y-2" wire:transition>
                @forelse($countries as $country)
                    <flux:callout color="sky" icon="flag" heading="{{ $country['name'] }}"/>
                @empty
                    <div class="text-center py-10">
                        <flux:text class="text-zinc-500">No countries found.</flux:text>
                    </div>
                @endforelse

            </div>

            @if($cursor && count($countries))
                <div class="flex justify-center mt-6">
                    <flux:badge as="button" wire:click="loadMore" variant="pill" icon:trailing="arrow-down" size="sm" color="sky" class="animate-bounce cursor-pointer capitalize">
                        Show More Countries
                    </flux:badge>
                </div>
            @endif

        </flux:card>
    </div>
</div>