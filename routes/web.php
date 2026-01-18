<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('jokes', 'pages::jokes.index')->name('jokes.index');
    Route::livewire('jokes/create', 'pages::jokes.create')->name('jokes.create');
});

require __DIR__.'/settings.php';
