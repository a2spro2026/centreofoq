<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login', function () {
    return back()->with('status', 'Connexion à brancher sur l’authentification.');
})->name('login.attempt');
