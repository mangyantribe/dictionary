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
    public $country_id;

    public function boot(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    #[On('add-country')] 
    public function addCountry()
    {   
        $this->resetFields();
        $this->addCountryModal = true;
    }

    #[On('edit-country')]
    public function editCountry($id)
    {
        $country = $this->countryService->findCountry($id);
        $this->country_id = $country->id;
        $this->name =  $country->name;
        $this->addCountryModal = true;
    }

    public function saveCountry()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $data = (object) [
            'id'   => $this->country_id,
            'name' => ucfirst($this->name),
        ];

        $results = $this->countryService->saveCountry($data);

        if ($results) {
            Flux::toast( variant: 'success', heading: $this->country_id ? 'Updated' : 'Created', text: $this->country_id ? 'Country has been updated.' : 'New country has been created.');
            $this->dispatch('refresh-countries');
            $this->resetFields();
            $this->addCountryModal = false;

        } else {
            Flux::toast(variant: 'danger', heading: 'Error',text: 'Something went wrong!');
        }
    }

    public function resetFields()
    {
        $this->reset(['country_id','name']);
    }
};
?>

<flux:modal wire:model.self="addCountryModal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $country_id ? 'Edit Country' : 'Add Country' }}</flux:heading>
        </div>

        <flux:input wire:model="name" label="Country Name" placeholder="Country Name"/>

        <div class="flex">
            <flux:spacer />
            <flux:button wire:click="saveCountry" variant="primary">{{ $country_id ? 'Update' : 'Save changes' }}</flux:button>
        </div>

    </div>
</flux:modal>