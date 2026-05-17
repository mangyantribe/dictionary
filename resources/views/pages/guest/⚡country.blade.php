<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
new #[Layout('layouts::guest')] class extends Component
{
    //
};
?>


<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900 px-4">
    <div class="w-full max-w-lg">
        <flux:card class="space-y-2 hover:cursor-pointer">
            <flux:callout variant="secondary" icon="information-circle" heading="Your account has been successfully created." />
            <flux:callout variant="success" icon="check-circle" heading="Your account is verified and ready to use." />
            <flux:callout variant="warning" icon="exclamation-circle" heading="Please verify your account to unlock all features." />
            <flux:callout variant="danger" icon="x-circle" heading="Something went wrong. Try again or contact support." />
        </flux:card>
    </div>
</div>