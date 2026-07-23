<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session('auth.role') === 'administration') {
        return redirect()->route('admin.dashboard');
    }

    return view('welcome');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'role' => ['required', 'string'],
        'email' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $isAdmin =
        $credentials['role'] === 'administration'
        && strcasecmp(trim($credentials['email']), 'admin@horizon.com') === 0
        && $credentials['password'] === 'password';

    if (! $isAdmin) {
        return back()
            ->withInput($request->only('email', 'role'))
            ->withErrors(['email' => 'Identifiants incorrects. Vérifiez le statut, l’e-mail et le mot de passe.']);
    }

    $request->session()->regenerate();
    $request->session()->put('auth', [
        'role' => 'administration',
        'email' => 'admin@horizon.com',
        'name' => 'Directeur général',
        'title' => 'Administration',
    ]);

    return redirect()->route('admin.dashboard');
})->name('login.attempt');

Route::post('/logout', function (Request $request) {
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::get('/admin', function () {
    if (session('auth.role') !== 'administration') {
        return redirect()->route('login');
    }

    return view('admin.dashboard', [
        'user' => session('auth'),
    ]);
})->name('admin.dashboard');
