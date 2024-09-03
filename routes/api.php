<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ShowController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/shows', 'as' => 'shows.'], function () {
    Route::get('/', [ShowController::class, 'index'])
        ->name('index');
    Route::get('/{showId}/events', [ShowController::class, 'eventsByShow'])
        ->where('showId', '[0-9]+')
        ->name('events');
});

Route::group(['prefix' => '/events', 'as' => 'events.'], function () {
    Route::get('/{eventId}/places', [EventController::class, 'getEventPlaces'])
        ->where('eventId', '[0-9]+')
        ->name('places');
    Route::post('/{eventId}/reserve', [EventController::class, 'reserve'])
        ->where('eventId', '[0-9]+')
        ->name('reserve');
});
