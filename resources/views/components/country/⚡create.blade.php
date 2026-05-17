<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CountryService;
use Flux\Flux;
new class extends Component
{
    protected $countryService;
    public $addCountryModal = false;
    public $name;

    public function boot(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    #[On('add-country')] 
    public function addCountry()
    {   
        $this->addCountryModal = true;
    }

    public function saveCountry()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $data = (object) [
            'name' => ucfirst($this->name),
        ];

        $results = $this->countryService->saveCountry($data);
        if($results){
            Flux::toast(variant: 'success',heading: 'Created',text: 'New country has been created.');    
            $this->addCountryModal = false;
        }else{
            Flux::toast(variant: 'danger',heading: 'Error',text: 'Something went wrong!');
        }
    }
};
?>

<flux:modal wire:model.self="addCountryModal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Add Country</flux:heading>
        </div>

        <flux:input wire:model="name" label="Country Name" placeholder="Country Name" />

        <div class="flex">
            <flux:spacer />

            <flux:button wire:click="saveCountry" variant="primary">Save changes</flux:button>
        </div>
    </div>
</flux:modal>