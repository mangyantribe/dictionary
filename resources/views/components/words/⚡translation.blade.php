<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\CountryService;
use App\Services\WordService;
use Flux\Flux;
new class extends Component
{
    protected $countryService;
    protected $wordService;
    public $searchCountry;
    public $wordId;
    public $country = '', $translation, $filipino, $example;


    public $translations = [];
    public $cursor = null;

    public function boot(CountryService $countryService,WordService $wordService)
    {
        $this->countryService = $countryService;
        $this->wordService = $wordService;
    }

    public function mount()
    {
        $this->loadTranslation();
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
        $object->country = $this->country;
        $object->wordId = $this->wordId;
        $object->translation = strtolower($this->translation);
        $object->example = $this->example;


        $result = $this->wordService->saveTranslation($object);

        if($result){
            $this->dispatch('refresh-translation');
            Flux::toast(variant: 'success',heading: 'Created',text : 'New translation has been created.');
        }
    }


    public function loadTranslation()
    {
        $result = $this->wordService->getTranslation($this->wordId,$this->cursor);
        $this->translations = array_merge($this->translations,$result['data']); 
        $this->cursor = $result['cursor'];
    }

    public function loadMore()
    {
        if (!$this->cursor) return;

        $this->loadTranslation();
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
                    @foreach ($this->translations as $translation)
                    <div class="rounded-lg border p-4">
                        <p class="font-medium">{{ $translation['country'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $translation['translation'] }}</p>
                    </div>
                    @endforeach
                </div>

                @if($cursor && count($translations))
                    <div class="flex justify-center mt-6">
                        <flux:badge as="button" wire:click="loadMore" variant="pill" icon:trailing="arrow-down" size="sm" color="sky" class="animate-bounce cursor-pointer capitalize">
                            Show More Translation
                        </flux:badge>
                    </div>
                @endif
            </div>
        </flux:fieldset>
    </div>


</div>