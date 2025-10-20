<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::resource('animales', AnimalController::class)->parameters([
    'animales' => 'animal'
]);
Route::get('animales-export', [AnimalController::class, 'export'])
    ->name('animales.export');