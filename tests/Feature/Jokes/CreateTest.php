<?php

use App\Enums\Language;
use App\Models\User;
use Livewire\Livewire;

it('requires authentication to access the create joke page', function () {
    $this->get(route('jokes.create'))
        ->assertRedirect(route('login'));
});

it('displays the create joke page', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get(route('jokes.create'))
        ->assertOk()
        ->assertSee('Create Joke')
        ->assertSee('Dashboard')
        ->assertSeeInOrder(['<title>', 'Create Joke']);
});

it('can create a joke', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::jokes.create')
        ->set('text', 'Why did the chicken cross the road?')
        ->set('language', Language::English->value)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('jokes', [
        'text' => 'Why did the chicken cross the road?',
        'language' => Language::English->value,
    ]);
});

it('validates the joke text is required', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::jokes.create')
        ->set('text', '')
        ->set('language', Language::English->value)
        ->call('save')
        ->assertHasErrors(['text' => 'required']);
});

it('validates the joke language is required', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::jokes.create')
        ->set('text', 'Joke text')
        ->set('language', '')
        ->call('save')
        ->assertHasErrors(['language' => 'required']);
});

it('validates the joke text is maximum 500 characters', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::jokes.create')
        ->set('text', str_repeat('a', 501))
        ->set('language', Language::English->value)
        ->call('save')
        ->assertHasErrors(['text' => 'max']);
});
