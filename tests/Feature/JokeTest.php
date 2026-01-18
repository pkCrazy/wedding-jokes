<?php

use App\Models\Joke;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

describe('Joke', function () {
    it('can create a joke', function () {
        $joke = Joke::factory()->create([
            'text' => 'Why did the chicken cross the road? To get to the other side!',
        ]);

        expect($joke->text)->toBe('Why did the chicken cross the road? To get to the other side!');
        $this->assertDatabaseHas('jokes', [
            'id' => $joke->id,
            'text' => 'Why did the chicken cross the road? To get to the other side!',
        ]);
    });

    it('can create a joke with maximum 500 characters', function () {
        $longText = str_repeat('a', 500);
        $joke = Joke::factory()->create([
            'text' => $longText,
        ]);

        expect(strlen($joke->text))->toBe(500);
        $this->assertDatabaseHas('jokes', [
            'id' => $joke->id,
            'text' => $longText,
        ]);
    });

    it('throws an exception when text exceeds 500 characters', function () {
        $tooLongText = str_repeat('a', 501);

        $this->expectException(QueryException::class);

        Joke::factory()->create([
            'text' => $tooLongText,
        ]);

        assertDatabaseMissing('jokes', ['text' => $tooLongText]);
    });
});
