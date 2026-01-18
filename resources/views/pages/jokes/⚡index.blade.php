<?php

use App\Models\Joke;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\LazyCollection;

new #[Title('Jokes')] class extends Component
{
    public function with(): array
    {
        return [
            'numberOfJokes' => Joke::count(),
            'jokes' => Joke::cursor(),
        ];
    }

    public function delete(Joke $joke): void
    {
        $joke->delete();
    }
};
?>

<section class="w-full">
    <div class="flex items-start justify-between mb-6">
        <flux:heading size="xl" level="1">{{ __('Jokes') }} - {{ $numberOfJokes }}</flux:heading>
        <flux:button :href="route('jokes.create')" variant="primary" wire:navigate>
            {{ __('Create Joke') }}
        </flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($jokes as $joke)
            <div wire:key="joke-{{ $joke->id }}" class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm flex flex-col justify-between">
                <flux:text class="line-clamp-6 mb-4">
                    {!! nl2br(e($joke->text)) !!}
                </flux:text>

                <div class="flex justify-end">
                    <flux:button
                        variant="danger"
                        size="sm"
                        wire:click="delete({{ $joke->id }})"
                        wire:confirm="{{ __('Are you sure you want to delete this joke?') }}"
                    >
                        {{ __('Delete') }}
                    </flux:button>
                </div>
            </div>
        @endforeach
    </div>
</section>
