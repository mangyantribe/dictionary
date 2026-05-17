<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
new class extends Component
{
    #[Computed]
    public function countries()
    {
        return [];
    }
};
?>

<flux:table>
    <flux:table.columns>
        <flux:table.column>Photo</flux:table.column>
        <flux:table.column>Name</flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @foreach ($this->countries as $country)
            <flux:table.row :key="$country->id">
                <flux:table.cell class="flex items-center gap-3">
                    <flux:avatar size="xs" color="auto" color:seed="{{ $country->id }}"/>
                </flux:table.cell>
                <flux:table.cell variant="strong">{{ $order->amount }}</flux:table.cell>

                <flux:table.cell>
                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
