<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Services\WordService;
new class extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $wordService;
    public $search;

    public function boot(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    #[On('refresh-words')] 
    #[Computed]
    public function words()
    {
        return $this->wordService->getWords($this->search);
    }

    public function editWord($id)
    {
        $this->dispatch('edit-word',id:$id);
    }

    public function deleteWord($id)
    {
        $this->dispatch('delete-word',id:$id);
    }
};
?>
<div class="flex flex-col items-center space-y-4">

    <flux:input wire:model.live.debounce.300ms="search" class="w-full max-w-xs mt-5" placeholder="Search word"/>

    <div class="w-full">
        <flux:table :paginate="$this->words">
            <flux:table.columns>
                <flux:table.column>Words</flux:table.column>
                <flux:table.column align="end"></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>

                @forelse ($this->words as $word)

                    <flux:table.row :key="$word->id">
                        <flux:table.cell variant="strong">
                            {{ $word->word }}
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <flux:button variant="primary" wire:click="editWord({{ $word->id }})">
                                Edit
                            </flux:button>

                            <flux:button variant="danger" wire:click="deleteWord({{ $word->id }})">
                                Delete
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>

                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="2" class="text-center py-10">
                            <div class="text-zinc-500">
                                No results found.
                            </div>
                        </flux:table.cell>
                    </flux:table.row>

                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>
</div>