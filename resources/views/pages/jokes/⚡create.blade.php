<?php

use App\Models\Joke;
use App\Enums\Language;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Validation\Rule;

new #[Title('Create Joke')] class extends Component
{
    public string $text = '';

    public ?string $language = null;

    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:500'],
            'language' => ['required', Rule::enum(Language::class)],
        ];
    }

    public function save(): void
    {
        $this->validate();

        Joke::create([
            'text' => $this->text,
            'language' => $this->language,
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

        <flux:select wire:model="language" :label="__('Language')" :placeholder="__('Choose a language...')">
            @foreach (Language::cases() as $lang)
                <option value="{{ $lang->value }}">{{ $lang->name }}</option>
            @endforeach
        </flux:select>

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
