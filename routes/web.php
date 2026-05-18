<?php

use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome')->name('home');

Route::livewire('/', 'pages::guest.country')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('country', 'pages::dictionary.country')->name('country');
    Route::livewire('words', 'pages::dictionary.words')->name('words');
    Route::livewire('translation/{word}', 'pages::dictionary.translation')->name('translation')->middleware('signed');
});

require __DIR__.'/settings.php';
