<?php

use App\Models\Joke;
use App\Models\User;
use Livewire\Livewire;

it('requires authentication to access the jokes page', function () {
    $this->get(route('jokes.index'))
        ->assertRedirect(route('login'));
});

it('displays the jokes page', function () {
    $user = User::factory()->create();
    $jokes = Joke::factory(3)->create();

    $this->actingAs($user);

    $this->get(route('jokes.index'))
        ->assertOk()
        ->assertSee('Jokes - 3')
        ->assertSee($jokes[0]->text)
        ->assertSee($jokes[1]->text)
        ->assertSee($jokes[2]->text);
});

it('displays jokes in the component', function () {
    $user = User::factory()->create();
    Joke::factory(10)->create();

    $this->actingAs($user);

    Livewire::test('pages::jokes.index')
        ->assertViewHas('jokes', function ($jokes) {
            return $jokes instanceof \Illuminate\Support\LazyCollection && $jokes->count() === 10;
        });
});
