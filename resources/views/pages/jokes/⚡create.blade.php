<?php

use App\Models\Joke;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Create Joke')] class extends Component
{
    #[Validate('required|string|max:500')]
    public string $text = '';

    public function save(): void
    {
        $this->validate();

        Joke::create([
            'text' => $this->text,
        ]);

        $this->reset();
    }
};
?>

<section class="w-full">
    <div class="flex items-start justify-between">
        <flux:heading size="xl" level="1">{{ __('Create Joke') }}</flux:heading>
    </div>

    <form wire:submit="save" class="mt-6 w-full max-w-lg space-y-6">
        <flux:textarea
            wire:model="text"
            :label="__('Joke Text')"
            :placeholder="__('Enter your joke here...')"
            rows="5"
            autofocus
        />

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">
                {{ __('Create Joke') }}
            </flux:button>

            <flux:button :href="route('dashboard')" variant="ghost" wire:navigate>
                {{ __('Cancel') }}
            </flux:button>
        </div>
    </form>
</section>
