<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Word;
new #[Title('Translation')] class extends Component
{
    public Word $word;

    public function mount(Word $word)
    {
        $this->word = $word;
    }
};
?>

<div>
    <flux:heading  size="xl" level="1" class="flex flex-col gap-4 sm:flex-row sm:items-center">
        {{ __(ucfirst($word->word)) }}
        <flux:spacer />
    </flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Word Translation for '. $word->word) }}</flux:subheading>
    <flux:separator variant="subtle" />
    <livewire:words.translation :wordId="$word->id"/>
</div>