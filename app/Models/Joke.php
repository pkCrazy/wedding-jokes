<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joke extends Model
{
    /** @use HasFactory<\Database\Factories\JokeFactory> */
    use HasFactory;

    protected $fillable = [
        'text',
        'language',
    ];

    protected function casts(): array
    {
        return [
            'language' => \App\Enums\Language::class,
        ];
    }
}
