<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CountryService;
use Flux\Flux;
new class extends Component
{
    protected $countryService;
    public $deleteCountryModal = false;
    public $country;
    public $country_id;

    public function boot(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    #[On('delete-country')]
    public function deleteCountry($id)
    {
        $country = $this->countryService->findCountry($id);
        $this->country = $country;
        $this->deleteCountryModal = true;
    }

    public function confirmDeletion()
    {
        if($this->country->delete()){
            Flux::toast( variant: 'success', heading: 'Deleted', text:'Country has been delete.');
            $this->dispatch('refresh-countries');
            $this->deleteCountryModal = false;
        }
    }
};
?>


<flux:modal wire:model.self="deleteCountryModal" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete {{ $country->name ?? "" }}?</flux:heading>

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