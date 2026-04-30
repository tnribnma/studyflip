<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.check')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile',         [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',         [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',[ProfileController::class, 'changePassword'])->name('profile.password');

    Route::get('/decks',             [DeckController::class, 'index'])->name('decks.index');
    Route::get('/decks/create',      [DeckController::class, 'create'])->name('decks.create');
    Route::post('/decks',            [DeckController::class, 'store'])->name('decks.store');
    Route::get('/decks/{deck}',      [DeckController::class, 'show'])->name('decks.show');
    Route::get('/decks/{deck}/edit', [DeckController::class, 'edit'])->name('decks.edit');
    Route::put('/decks/{deck}',      [DeckController::class, 'update'])->name('decks.update');
    Route::delete('/decks/{deck}',   [DeckController::class, 'destroy'])->name('decks.destroy');
    Route::get('/decks/{deck}/study',[DeckController::class, 'study'])->name('decks.study');

    Route::get('/decks/{deck}/cards/create',   [CardController::class, 'create'])->name('cards.create');
    Route::post('/decks/{deck}/cards',         [CardController::class, 'store'])->name('cards.store');
    Route::get('/decks/{deck}/cards/{card}/edit',   [CardController::class, 'edit'])->name('cards.edit');
    Route::put('/decks/{deck}/cards/{card}',        [CardController::class, 'update'])->name('cards.update');
    Route::delete('/decks/{deck}/cards/{card}',     [CardController::class, 'destroy'])->name('cards.destroy');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
