<?php

use App\Enums\Language;
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

    $response = $this->get(route('jokes.index'));

    $response->assertOk()
        ->assertSee('Jokes - 3');

    foreach ($jokes as $joke) {
        $response->assertSee($joke->text);
    }
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

it('can filter jokes by language', function () {
    $user = User::factory()->create();
    Joke::factory(5)->create(['language' => Language::English]);
    Joke::factory(3)->create(['language' => Language::Hungarian]);

    $this->actingAs($user);

    Livewire::test('pages::jokes.index')
        ->assertViewHas('jokes', function ($jokes) {
            return $jokes->count() === 8;
        })
        ->set('language', Language::English->value)
        ->assertViewHas('jokes', function ($jokes) {
            return $jokes->count() === 5;
        })
        ->set('language', Language::Hungarian->value)
        ->assertViewHas('jokes', function ($jokes) {
            return $jokes->count() === 3;
        })
        ->set('language', '')
        ->assertViewHas('jokes', function ($jokes) {
            return $jokes->count() === 8;
        });
});
