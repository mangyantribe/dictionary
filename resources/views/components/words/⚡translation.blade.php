<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\CountryService;
use App\Services\WordService;
use Livewire\Attributes\On;
use Flux\Flux;
new class extends Component
{
    protected $countryService;
    protected $wordService;
    public $searchCountry;
    public $wordId;
    public $country = '', $kahulugan, $salin, $halimbawa;


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
            'kahulugan' => 'required',
            'halimbawa' => 'required',
        ]);

        $object = new \stdClass();
        $object->country = $this->country;
        $object->wordId = $this->wordId;
        $object->kahulugan = strtolower($this->kahulugan);
        $object->salin = $this->salin;
        $object->halimbawa = $this->halimbawa;

        $result = $this->wordService->saveTranslation($object);

        if($result){
            $this->translations = [];
            $this->cursor = null;
            $this->loadTranslation();
            $this->resetFields();
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

    public function resetFields()
    {
        $this->reset(['country','kahulugan','salin','halimbawa']);
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
                    <flux:textarea wire:model="kahulugan" label="Kahulugan" placeholder="Isulat ang kahulugan..."/>
                    <flux:textarea wire:model="salin" label="Salin (Pilipino)" placeholder="isulat ang salin..."/>
                    <flux:textarea wire:model="halimbawa" label="Halimbawa" placeholder="isulat ang halimbawa..."/>
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
                        <p class="text-sm text-zinc-500">{{ $translation['kahulugan'] }}</p>
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