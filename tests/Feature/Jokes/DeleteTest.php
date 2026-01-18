<?php

use App\Models\Joke;
use App\Models\User;
use Livewire\Livewire;

it('can delete a joke', function () {
    $user = User::factory()->create();
    $joke = Joke::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::jokes.index')
        ->call('delete', $joke->id)
        ->assertOk();

    $this->assertDatabaseMissing('jokes', [
        'id' => $joke->id,
    ]);
});
