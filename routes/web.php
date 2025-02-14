<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\GamesController;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::prefix('games')
    ->controller(GamesController::class)
    ->middleware(['auth'])
    ->group(function () {
        Volt::route('/create', 'games.create')->name('games.create');

        Route::get('/', 'index')->name('games.index');
        Route::post('/join', 'join')->name('games.join');

        Route::get('/{game}', 'show')->name('games.show');
        Route::get('/{game}/movement', 'movement')->name('games.movement');

        Route::post('/{game}/send', 'send_money')->name('games.send');
    });

require __DIR__.'/auth.php';
