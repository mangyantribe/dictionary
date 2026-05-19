<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Services\CountryService;
new class extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $countryService;

    public function boot(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    #[On('refresh-countries')] 
    #[Computed]
    public function countries()
    {
        return $this->countryService->getCounties();
    }

    public function editCountry($id)
    {
        $this->dispatch('edit-country',id:$id);
    }

    public function deleteCountry($id)
    {
        $this->dispatch('delete-country',id:$id);
    }
};
?>

<flux:table :paginate="$this->countries">
    <flux:table.columns>
        <flux:table.column>Photo</flux:table.column>
        <flux:table.column>Code</flux:table.column>
        <flux:table.column>Name</flux:table.column>
        <flux:table.column align="end"></flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @foreach ($this->countries as $country)
            <flux:table.row :key="$country->id">
                <flux:table.cell class="flex items-center gap-3">
                    <flux:avatar circle color="auto" color:seed="{{ $country->id }}" :name="$country->name"/>
                </flux:table.cell>
                <flux:table.cell variant="strong">{{ $country->code }}</flux:table.cell>
                <flux:table.cell variant="strong">{{ $country->name }}</flux:table.cell>
                <flux:table.cell align="end">
                    <flux:button variant="primary" wire:click="editCountry({{ $country->id }})">Edit</flux:button>
                    <flux:button variant="danger" wire:click="deleteCountry({{ $country->id }})">Delete</flux:button>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
