<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CountryService;
use Livewire\WithFileUploads;
use Flux\Flux;
new class extends Component
{
    use WithFileUploads;
    protected $countryService;
    public $addCountryModal = false;
    public $name, $code;
    public $country_id;
    public $photo;

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
        $this->code =  $country->code;
        $this->addCountryModal = true;
    }

    public function saveCountry()
    {
        $this->validate([
            'name'  => 'required',
            'code'  => 'required|unique:countries,code,' . $this->country_id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;

        if ($this->photo) {
            $photoPath = $this->photo->store('countries', 'public');
        }

        $data = (object) [
            'id'   => $this->country_id,
            'code'  => strtolower($this->code),
            'name' => ucfirst($this->name),
            'photo' => $photoPath,
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
        $this->reset(['country_id','name','code','photo']);
    }

    /**
     * remove file from preview
    */
    public function removePhoto()
    {
        $this->photo->delete();
        $this->photo = null;
    }
};
?>

<flux:modal wire:model.self="addCountryModal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $country_id ? 'Edit Country' : 'Add Country' }}</flux:heading>
        </div>

        <flux:input wire:model="name" label="Country Name" placeholder="Country Name"/>
        <flux:input wire:model="code" label="Country Code" placeholder="Country Code"/>

        <flux:file-upload wire:model="photo">
            <flux:file-upload.dropzone with-progress inline heading="Drop photo here or click to browse" text="JPG, PNG up to 10MB" />
        </flux:file-upload>
        <div class="mt-3 flex flex-col gap-2">
            @if($photo)
                @php
                  $isImage = str_starts_with($photo->getMimeType(),'image/') ? true : false;
                @endphp

                @if($isImage)
                <flux:file-item :heading="$photo->getClientOriginalName()" :image="$photo->temporaryUrl()" :size="$photo->getSize()">
                    <x-slot name="actions">
                        <flux:file-item.remove wire:click="removePhoto" aria-label="{{ 'Remove file: ' . $photo->getClientOriginalName() }}" />
                    </x-slot>
                </flux:file-item>
                @else
                <flux:file-item heading="{{ $photo->getClientOriginalName() }}">
                    <x-slot name="actions">
                        <flux:file-item.remove wire:click="removePhoto" aria-label="{{ 'Remove file: ' . $photo->getClientOriginalName() }}" />
                    </x-slot>
                </flux:file-item>
                  
                @endif
            @endif
        </div>
        <div class="flex">
            <flux:spacer />
            <flux:button wire:click="saveCountry" variant="primary">{{ $country_id ? 'Update' : 'Save changes' }}</flux:button>
        </div>

    </div>
</flux:modal>