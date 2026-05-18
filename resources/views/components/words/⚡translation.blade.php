<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\CountryService;
use Flux\Flux;
new class extends Component
{
    protected $countryService;
    public $searchCountry;
    public $country = '',$translation,$filipino,$example;

    public function boot(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    #[Computed]
    public function countries()
    {
        return $this->countryService->getSearchCountries($this->searchCountry);
    }

    public function submitTranslation()
    {
        $this->validate([
            'country' => 'required',
            'translation' => 'required',
            'example' => 'required',
        ]);

        $object = new \stdClass();
        $object->id = $this->id;
        $object->exams = $this->exams;

        $result = $this->applicantService->retakeExam($object);
        if($result){
            $this->dispatch('refresh-applicant');
            Flux::toast(variant: 'success',heading: 'Retake On',text : 'Applicant has been allowed to retake exam');
            $this->retakeModal = false;
        }
    }
};
?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-5">
    <div>
        <flux:fieldset>
            <div class="space-y-6">
                <form wire:submit.prevent="submitTranslation" class="space-y-5">
                    <flux:select wire:model="country" variant="combobox" :filter="false" label="Country">
                          <x-slot name="input">
                              <flux:select.input wire:model.live.debounce.1s="searchCountry" placeholder="Search Country..." />
                          </x-slot>
                          @foreach ($this->countries as $country)
                              <flux:select.option :value="$country->id">{{ $country->name }}</flux:select.option>
                          @endforeach
                      </flux:select>
                    <flux:textarea wire:model="translation" label="Translation" placeholder="Write the translation..."/>
                    <flux:textarea wire:model="example" label="Example" placeholder="Write the example..."/>
                    <flux:button variant="primary" type="submit" class="w-full">
                        Save Translation
                    </flux:button>
                </form>
            </div>
        </flux:fieldset>
    </div>
    <div>
        <flux:fieldset>
            <div class="space-y-4">
                <h2 class="text-lg font-semibold">Translations</h2>

                <div class="space-y-3">
                    <div class="rounded-lg border p-4">
                        <p class="font-medium">English Translation</p>
                        <p class="text-sm text-zinc-500">Updated 2 hours ago</p>
                    </div>

                    <div class="rounded-lg border p-4">
                        <p class="font-medium">French Translation</p>
                        <p class="text-sm text-zinc-500">Updated yesterday</p>
                    </div>

                    <div class="rounded-lg border p-4">
                        <p class="font-medium">Spanish Translation</p>
                        <p class="text-sm text-zinc-500">Updated 3 days ago</p>
                    </div>
                </div>
            </div>
        </flux:fieldset>
    </div>


</div>